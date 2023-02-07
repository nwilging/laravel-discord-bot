<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Interactions\Handlers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Mockery\MockInterface;
use Nwilging\LaravelDiscordBot\Contracts\Listeners\ApplicationCommandInteractionEventListenerContract;
use Nwilging\LaravelDiscordBot\Events\ApplicationCommandInteractionEvent;
use Nwilging\LaravelDiscordBot\Support\Interactions\Handlers\ApplicationCommandHandler;
use Nwilging\LaravelDiscordBot\Support\Interactions\InteractionHandler;
use Nwilging\LaravelDiscordBotTests\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;

class ApplicationCommandHandlerTest extends TestCase
{
    protected string $defaultBehavior = 'defer';

    protected MockInterface $eventDispatcher;

    protected MockInterface $laravel;

    protected ApplicationCommandHandler $handler;

    public function setUp(): void
    {
        parent::setUp();

        $this->eventDispatcher = \Mockery::mock(Dispatcher::class);
        $this->laravel = \Mockery::mock(Application::class);

        $this->handler = new ApplicationCommandHandler($this->defaultBehavior, $this->eventDispatcher, $this->laravel);
    }

    public function testHandleDispatchesToApplicationListenersAndReturnsCustomResponse()
    {
        $parameterBag = \Mockery::mock(ParameterBag::class);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('json')->andReturn($parameterBag);

        $listener1Class = 'test-listener-1';
        $listener2Class = 'test-listener-2';

        $listener1 = function () {
            static $listener = 'test-listener-1';
        };

        $listener2 = function () {
            static $listener = 'test-listener-2';
        };

        $randomAppListener = \Mockery::mock(ShouldQueue::class);
        $customResponseListener = \Mockery::mock(ApplicationCommandInteractionEventListenerContract::class);

        $this->eventDispatcher->shouldReceive('getListeners')
            ->once()
            ->with(ApplicationCommandInteractionEvent::class)
            ->andReturn([$listener1, $listener2]);

        $this->laravel->shouldReceive('make')->once()->with($listener1Class)->andReturn($randomAppListener);
        $this->laravel->shouldReceive('make')->once()->with($listener2Class)->andReturn($customResponseListener);

        $this->eventDispatcher->shouldReceive('dispatch')
            ->once()
            ->with(\Mockery::on(function (ApplicationCommandInteractionEvent $event) use ($parameterBag): bool {
                $this->assertSame($parameterBag, $event->getInteractionRequest());
                return true;
            }));

        $customResponseListener->shouldReceive('replyContent')->once()->andReturn('custom reply');
        $customResponseListener->shouldReceive('behavior')->once()->andReturn(ApplicationCommandInteractionEventListenerContract::REPLY_TO_MESSAGE);

        $result = $this->handler->handle($request);
        $this->assertEquals(200, $result->getStatus());
        $this->assertEquals([
            'type' => ApplicationCommandInteractionEventListenerContract::REPLY_TO_MESSAGE,
            'data' => [
                'content' => 'custom reply',
            ],
        ], $result->toArray());
    }

    public function testHandleDispatchesToListenersAndReturnsDefaultBehaviorResponse()
    {
        $parameterBag = \Mockery::mock(ParameterBag::class);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('json')->andReturn($parameterBag);

        $listener1Class = 'test-listener-1';

        $listener1 = function () {
            static $listener = 'test-listener-1';
        };

        $randomAppListener = \Mockery::mock(ShouldQueue::class);

        $this->eventDispatcher->shouldReceive('getListeners')
            ->once()
            ->with(ApplicationCommandInteractionEvent::class)
            ->andReturn([$listener1]);

        $this->laravel->shouldReceive('make')->once()->with($listener1Class)->andReturn($randomAppListener);
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once()
            ->with(\Mockery::on(function (ApplicationCommandInteractionEvent $event) use ($parameterBag): bool {
                $this->assertSame($parameterBag, $event->getInteractionRequest());
                return true;
            }));

        $result = $this->handler->handle($request);
        $this->assertEquals(200, $result->getStatus());
        $this->assertEquals([
            'type' => ApplicationCommandInteractionEventListenerContract::DEFER_WHILE_HANDLING,
        ], $result->toArray());
    }

    public function testHandleDispatchesToListenersAndReturnsDefaultBehaviorResponseLoad()
    {
        $parameterBag = \Mockery::mock(ParameterBag::class);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('json')->andReturn($parameterBag);

        $listener1Class = 'test-listener-1';

        $listener1 = function () {
            static $listener = 'test-listener-1';
        };

        $randomAppListener = \Mockery::mock(ShouldQueue::class);

        $this->eventDispatcher->shouldReceive('getListeners')
            ->once()
            ->with(ApplicationCommandInteractionEvent::class)
            ->andReturn([$listener1]);

        $this->laravel->shouldReceive('make')->once()->with($listener1Class)->andReturn($randomAppListener);
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once()
            ->with(\Mockery::on(function (ApplicationCommandInteractionEvent $event) use ($parameterBag): bool {
                $this->assertSame($parameterBag, $event->getInteractionRequest());
                return true;
            }));

        $handler = new ApplicationCommandHandler('load', $this->eventDispatcher, $this->laravel);
        $result = $handler->handle($request);
        $this->assertEquals(200, $result->getStatus());
        $this->assertEquals([
            'type' => ApplicationCommandInteractionEventListenerContract::LOAD_WHILE_HANDLING,
        ], $result->toArray());
    }

    public function testHandleDispatchesToListenersAndReturnsDeferWhenNoValidDefaultBehavior()
    {
        $parameterBag = \Mockery::mock(ParameterBag::class);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('json')->andReturn($parameterBag);

        $listener1Class = 'test-listener-1';

        $listener1 = function () {
            static $listener = 'test-listener-1';
        };

        $randomAppListener = \Mockery::mock(ShouldQueue::class);

        $this->eventDispatcher->shouldReceive('getListeners')
            ->once()
            ->with(ApplicationCommandInteractionEvent::class)
            ->andReturn([$listener1]);

        $this->laravel->shouldReceive('make')->once()->with($listener1Class)->andReturn($randomAppListener);
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once()
            ->with(\Mockery::on(function (ApplicationCommandInteractionEvent $event) use ($parameterBag): bool {
                $this->assertSame($parameterBag, $event->getInteractionRequest());
                return true;
            }));

        $handler = new ApplicationCommandHandler('invalid', $this->eventDispatcher, $this->laravel);
        $result = $handler->handle($request);
        $this->assertEquals(200, $result->getStatus());
        $this->assertEquals([
            'type' => ApplicationCommandInteractionEventListenerContract::DEFER_WHILE_HANDLING,
        ], $result->toArray());
    }
}
