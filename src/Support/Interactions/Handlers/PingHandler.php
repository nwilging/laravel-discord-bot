<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Interactions\Handlers;

use Nwilging\LaravelDiscordBot\Support\Interactions\DiscordInteractionResponse;
use Nwilging\LaravelDiscordBot\Support\Interactions\InteractionHandler;

class PingHandler extends InteractionHandler
{
    public function handle($request): DiscordInteractionResponse
    {
        return new DiscordInteractionResponse(static::RESPONSE_TYPE_PONG);
    }
}
