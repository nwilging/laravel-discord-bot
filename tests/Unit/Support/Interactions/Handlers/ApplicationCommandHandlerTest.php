<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Interactions\Handlers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Mockery\MockInterface;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandManagerContract;
use Nwilging\LaravelDiscordBot\Events\ApplicationCommandInteractionEvent;
use Nwilging\LaravelDiscordBot\Jobs\ProcessApplicationCommandJob;
use Nwilging\LaravelDiscordBot\Support\Interactions\Handlers\ApplicationCommandHandler;
use Nwilging\LaravelDiscordBot\Support\Internal\Commands\Command;
use Nwilging\LaravelDiscordBotTests\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Contracts\Bus\Dispatcher as JobDispatcher;

class ApplicationCommandHandlerTest extends TestCase
{
    protected string $defaultBehavior = 'defer';

    protected CommandManagerContract $commandManager;

    protected MockInterface $eventDispatcher;

    protected MockInterface $jobDispatcher;

    protected MockInterface $laravel;

    protected ApplicationCommandHandler $handler;

    public function setUp(): void
    {
        parent::setUp();

        $this->eventDispatcher = \Mockery::mock(Dispatcher::class);
        $this->commandManager = \Mockery::mock(CommandManagerContract::class);
        $this->jobDispatcher = \Mockery::mock(JobDispatcher::class);
        $this->laravel = \Mockery::mock(Application::class);

        $this->handler = new ApplicationCommandHandler(
            $this->defaultBehavior,
            $this->commandManager,
            $this->eventDispatcher,
            $this->jobDispatcher,
            $this->laravel
        );
    }

    public function testHandleCallsCommandHandler()
    {
        $parameterBag = new ParameterBag([
            'data' => [
                'type' => Command::TYPE_CHAT_INPUT,
                'name' => 'test-command',
            ],
        ]);

        $command = \Mockery::mock(Command::class);
        $command->shouldReceive('setEvent')
            ->once()
            ->with(\Mockery::type(ApplicationCommandInteractionEvent::class));

        $this->commandManager->shouldReceive('get')
            ->once()
            ->with(Command::TYPE_CHAT_INPUT, 'test-command')
            ->andReturn($command);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('json')->andReturn($parameterBag);

        $this->laravel->shouldReceive('call')
            ->once()
            ->with([$command, 'handle']);

        $this->handler->handle($request);
    }

    public function testHandleQueuesCommandHandler()
    {
        $parameterBag = new ParameterBag([
            'data' => [
                'type' => Command::TYPE_CHAT_INPUT,
                'name' => 'test-command',
            ],
        ]);

        $command = \Mockery::mock(Command::class, ShouldQueue::class);
        $this->commandManager->shouldReceive('get')
            ->once()
            ->with(Command::TYPE_CHAT_INPUT, 'test-command')
            ->andReturn($command);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('json')->andReturn($parameterBag);

        $this->jobDispatcher->shouldReceive('dispatch')
            ->once()
            ->with(\Mockery::on(function (ProcessApplicationCommandJob $job): bool {
                $reflected = new \ReflectionClass($job);

                $typeProp = $reflected->getProperty('type');
                $signatureProp = $reflected->getProperty('signature');
                $eventProp = $reflected->getProperty('event');

                $typeProp->setAccessible(true);
                $signatureProp->setAccessible(true);
                $eventProp->setAccessible(true);

                $this->assertEquals(Command::TYPE_CHAT_INPUT, $typeProp->getValue($job));
                $this->assertEquals('test-command', $signatureProp->getValue($job));
                $this->assertInstanceOf(ApplicationCommandInteractionEvent::class, $eventProp->getValue($job));

                return true;
            }));

        $this->laravel->shouldNotReceive('call');

        $this->handler->handle($request);
    }
}
