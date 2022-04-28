<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Interactions\Handlers;

use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Laravel\SerializableClosure\Support\ReflectionClosure;
use Nwilging\LaravelDiscordBot\Contracts\Listeners\MessageComponentInteractionEventListenerContract;
use Nwilging\LaravelDiscordBot\Events\MessageComponentInteractionEvent;
use Nwilging\LaravelDiscordBot\Support\Interactions\DiscordInteractionResponse;
use Nwilging\LaravelDiscordBot\Support\Interactions\InteractionHandler;

class MessageComponentInteractionHandler extends InteractionHandler
{
    protected string $defaultBehavior;

    protected EventDispatcher $dispatcher;

    protected Application $laravel;

    public function __construct(string $defaultBehavior, EventDispatcher $dispatcher, Application $laravel)
    {
        $this->defaultBehavior = $defaultBehavior;
        $this->dispatcher = $dispatcher;
        $this->laravel = $laravel;
    }

    public function handle(Request $request): DiscordInteractionResponse
    {
        if ($response = $this->shouldHandleEventExternally($request)) {
            return $response;
        }

        switch ($this->defaultBehavior) {
            case static::BEHAVIOR_LOAD:
                return new DiscordInteractionResponse(static::RESPONSE_TYPE_DEFERRED_CHANNEL_MESSAGE_WITH_SOURCE);
            case static::BEHAVIOR_DEFER:
                return new DiscordInteractionResponse(static::RESPONSE_TYPE_DEFERRED_UPDATE_MESSAGE);
        }

        return new DiscordInteractionResponse(static::RESPONSE_TYPE_DEFERRED_UPDATE_MESSAGE);
    }

    /**
     * Determines if an incoming interaction should be handled by the user's application or by this package directly.
     *
     * If there are any listeners subscribed to the MessageComponentInteractionEvent, those should be dispatched.
     * Additionally, if there is a listener implementing the contract MessageComponentInteractionEventListenerContract
     * then that listener should be instantiated and have certain methods called to generate a DiscordInteractionResponse.
     *
     * This essentially facilitates overriding the default behavior of responding to interaction requests.
     *
     * @return DiscordInteractionResponse|null
     */
    protected function shouldHandleEventExternally(Request $request): ?DiscordInteractionResponse
    {
        $listeners = $this->dispatcher->getListeners(MessageComponentInteractionEvent::class);
        $listenersImplementingInterface = array_values(array_map(function (\Closure $listener) {
            return $this->makeListenerFromClosure($listener);
        }, array_filter($listeners, function ($listener): bool {
            return $this->makeListenerFromClosure($listener) instanceof MessageComponentInteractionEventListenerContract;
        })));

        $event = new MessageComponentInteractionEvent($request->json());
        if (!empty($listeners)) {
            $this->dispatcher->dispatch($event);
        }

        if (empty($listenersImplementingInterface)) {
            return null;
        }

        /** @var MessageComponentInteractionEventListenerContract $listener */
        $listener = $listenersImplementingInterface[0];

        $replyContent = $listener->replyContent($event);
        $behavior = $listener->behavior($event);

        $data = null;
        if (!empty($replyContent)) {
            $data = [
                'content' => $replyContent,
            ];
        }

        return new DiscordInteractionResponse($behavior, $data);
    }

    protected function makeListenerFromClosure(\Closure $listenerClosure)
    {
        $reflected = new ReflectionClosure($listenerClosure);
        $attributes = $reflected->getStaticVariables();
        return $this->laravel->make($attributes['listener']);
    }
}
