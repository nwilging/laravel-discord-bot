<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Interactions\Handlers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Mockery\MockInterface;
use Nwilging\LaravelDiscordBot\Contracts\Listeners\ApplicationCommandInteractionEventListenerContract;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandContract;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandManagerContract;
use Nwilging\LaravelDiscordBot\Events\ApplicationCommandInteractionEvent;
use Nwilging\LaravelDiscordBot\Jobs\ProcessApplicationCommandJob;
use Nwilging\LaravelDiscordBot\Support\Command;
use Nwilging\LaravelDiscordBot\Support\Interactions\Handlers\ApplicationCommandHandler;
use Nwilging\LaravelDiscordBotTests\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Contracts\Bus\Dispatcher as JobDispatcher;

class ApplicationCommandHandlerTest extends TestCase
{
    protected string $defaultBehavior = 'defer';

    protected MockInterface $eventDispatcher;

    protected MockInterface $jobDispatcher;

    protected MockInterface $commandManager;

    protected MockInterface $laravel;

    protected ApplicationCommandHandler $handler;

    public function setUp(): void
    {
        parent::setUp();

        $this->eventDispatcher = \Mockery::mock(Dispatcher::class);
        $this->jobDispatcher = \Mockery::mock(JobDispatcher::class);
        $this->commandManager = \Mockery::mock(CommandManagerContract::class);
        $this->laravel = \Mockery::mock(Application::class);

        $this->handler = new ApplicationCommandHandler(
            $this->defaultBehavior,
            $this->commandManager,
            $this->eventDispatcher,
            $this->jobDispatcher,
            $this->laravel
        );
    }

    public function testHandleCallsCommand()
    {
        $parameterBag = \Mockery::mock(ParameterBag::class);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('json')->andReturn($parameterBag);

        $requestData = [
            'type' => Command::TYPE_CHAT_INPUT,
            'name' => 'test-command',
        ];

        $parameterBag->shouldReceive('get')->with('data', [])->andReturn($requestData);

        $command = $this->testCommand();
        $this->commandManager->shouldReceive('get')
            ->once()
            ->with(Command::TYPE_CHAT_INPUT, 'test-command')
            ->andReturn($command);

        $this->laravel->shouldReceive('call')
            ->once()
            ->with([$command, 'handle']);

        $result = $this->handler->handle($request);
        $this->assertEquals(200, $result->getStatus());
        $this->assertEquals([
            'type' => ApplicationCommandInteractionEventListenerContract::DEFER_WHILE_HANDLING,
        ], $result->toArray());
    }

    public function testHandleQueuesCommand()
    {
        $parameterBag = \Mockery::mock(ParameterBag::class);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('json')->andReturn($parameterBag);

        $requestData = [
            'type' => Command::TYPE_CHAT_INPUT,
            'name' => 'test-command',
        ];

        $parameterBag->shouldReceive('get')->with('data', [])->andReturn($requestData);

        $command = $this->testCommandQueueable();
        $this->commandManager->shouldReceive('get')
            ->once()
            ->with(Command::TYPE_CHAT_INPUT, 'test-command')
            ->andReturn($command);

        $this->jobDispatcher->shouldReceive('dispatch')
            ->once()
            ->with(\Mockery::on(function (ProcessApplicationCommandJob $job) use ($parameterBag): bool {
                $reflected = new \ReflectionClass($job);

                $typeProp = $reflected->getProperty('type');
                $signatureProp = $reflected->getProperty('signature');
                $eventProp = $reflected->getProperty('event');

                $typeProp->setAccessible(true);
                $signatureProp->setAccessible(true);
                $eventProp->setAccessible(true);

                $this->assertSame(Command::TYPE_CHAT_INPUT, $typeProp->getValue($job));
                $this->assertSame('test-command', $signatureProp->getValue($job));

                $this->assertSame($parameterBag, $eventProp->getValue($job)->getRequest());

                return true;
            }));

        $result = $this->handler->handle($request);
        $this->assertEquals(200, $result->getStatus());
        $this->assertEquals([
            'type' => ApplicationCommandInteractionEventListenerContract::DEFER_WHILE_HANDLING,
        ], $result->toArray());
    }

    public function testHandleOnlyReturnsDefaultBehaviorWhenNoCommandFound()
    {
        $parameterBag = \Mockery::mock(ParameterBag::class);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('json')->andReturn($parameterBag);

        $requestData = [
            'type' => Command::TYPE_CHAT_INPUT,
            'name' => 'test-command',
        ];

        $parameterBag->shouldReceive('get')->with('data', [])->andReturn($requestData);

        $this->commandManager->shouldReceive('get')
            ->once()
            ->with(Command::TYPE_CHAT_INPUT, 'test-command')
            ->andThrow(\InvalidArgumentException::class);

        $result = $this->handler->handle($request);
        $this->assertEquals(200, $result->getStatus());
        $this->assertEquals([
            'type' => ApplicationCommandInteractionEventListenerContract::DEFER_WHILE_HANDLING,
        ], $result->toArray());
    }

    protected function testCommand(): MockInterface
    {
        $command = new class implements CommandContract {
            public static function signature(): string
            {
                return 'test';
            }

            public static function description(): string
            {
                return 'test';
            }

            public static function guildId(): ?string
            {
                return null;
            }

            public static function type(): int
            {
                return 1;
            }

            public static function migrate(): Command
            {
                return \Mockery::mock(Command::class);
            }

            public function setEvent(ApplicationCommandInteractionEvent $event): void
            {
                //
            }

            public function handle(): void
            {
                //
            }
        };

        return \Mockery::mock($command);
    }

    protected function testCommandQueueable(): MockInterface
    {
        $command = new class implements CommandContract, ShouldQueue {
            public static function signature(): string
            {
                return 'test';
            }

            public static function description(): string
            {
                return 'test';
            }

            public static function guildId(): ?string
            {
                return null;
            }

            public static function type(): int
            {
                return 1;
            }

            public static function migrate(): Command
            {
                return \Mockery::mock(Command::class);
            }

            public function setEvent(ApplicationCommandInteractionEvent $event): void
            {
                //
            }

            public function handle(): void
            {
                //
            }
        };

        return \Mockery::mock($command);
    }
}
