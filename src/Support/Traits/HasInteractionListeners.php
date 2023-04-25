<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Traits;

use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Laravel\SerializableClosure\Support\ReflectionClosure;
use Nwilging\LaravelDiscordBot\Events\AbstractInteractionEvent;
use Nwilging\LaravelDiscordBot\Support\Interactions\DiscordInteractionResponse;

trait HasInteractionListeners
{
    protected EventDispatcher $dispatcher;

    protected Application $laravel;

    protected function makeListenerFromClosure(\Closure $listenerClosure)
    {
        $reflected = new ReflectionClosure($listenerClosure);
        $attributes = $reflected->getStaticVariables();
        return $this->laravel->make($attributes['listener']);
    }

    protected function getListenersFor(string $eventClass): array
    {
        $listeners = $this->dispatcher->getListeners($eventClass);
        return array_values(array_map(function (\Closure $listener) {
            return $this->makeListenerFromClosure($listener);
        }, $listeners));
    }

    protected function defaultBehaviorResponse(array $listeners, $event): DiscordInteractionResponse
    {
        $listener = $listeners[0];

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

    /**
     * Determines if an incoming interaction should be handled by the user's application or by this package directly.
     *
     * If there are any listeners subscribed to the Message- or App- ComponentInteractionEvent, those should be dispatched.
     * Additionally, if there is a listener implementing the contract Message- or App- ComponentInteractionEventListenerContract
     * then that listener should be instantiated and have certain methods called to generate a DiscordInteractionResponse.
     *
     * This essentially facilitates overriding the default behavior of responding to interaction requests.
     *
     * @return DiscordInteractionResponse|null
     */
    protected function generateResponse(AbstractInteractionEvent $event, string $listenerClass): ?DiscordInteractionResponse
    {
        $listeners = $this->getListenersFor(get_class($event));
        $listenersImplementingInterface = array_values(array_filter($listeners, function ($listener) use ($listenerClass): bool {
            return $listener instanceof $listenerClass;
        }));

        if (!empty($listeners)) {
            $this->dispatcher->dispatch($event);
        }

        if (empty($listenersImplementingInterface)) {
            return null;
        }

        return $this->defaultBehaviorResponse($listenersImplementingInterface, $event);
    }

    protected abstract function shouldHandleEventExternally(Request $request): ?DiscordInteractionResponse;

    protected function defaultBehavior(): DiscordInteractionResponse
    {
        switch ($this->defaultBehavior) {
            case static::BEHAVIOR_LOAD:
                return new DiscordInteractionResponse(static::RESPONSE_TYPE_DEFERRED_CHANNEL_MESSAGE_WITH_SOURCE);
            case static::BEHAVIOR_DEFER:
                return new DiscordInteractionResponse(static::RESPONSE_TYPE_DEFERRED_UPDATE_MESSAGE);
        }

        return new DiscordInteractionResponse(static::RESPONSE_TYPE_DEFERRED_UPDATE_MESSAGE);
    }
}
