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
use Nwilging\LaravelDiscordBot\Support\Traits\HasInteractionListeners;

class MessageComponentInteractionHandler extends InteractionHandler
{
    use HasInteractionListeners;

    protected string $defaultBehavior;

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

    protected function shouldHandleEventExternally(Request $request): ?DiscordInteractionResponse
    {
        return $this->generateResponse(
            new MessageComponentInteractionEvent($request->json()),
            MessageComponentInteractionEventListenerContract::class,
        );
    }
}
