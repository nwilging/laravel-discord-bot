<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Interactions\Handlers;

use Illuminate\Http\Request;
use Nwilging\LaravelDiscordBot\Support\Interactions\DiscordInteractionResponse;
use Nwilging\LaravelDiscordBot\Support\Interactions\InteractionHandler;

class ApplicationCommandHandler extends InteractionHandler
{
    public function handle(Request $request): DiscordInteractionResponse
    {
        return new DiscordInteractionResponse(static::RESPONSE_TYPE_DEFERRED_UPDATE_MESSAGE);
    }
}
