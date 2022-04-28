<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Interactions;

use Illuminate\Http\Request;

abstract class InteractionHandler
{
    public const REQUEST_TYPE_PING = 1;
    public const REQUEST_TYPE_APPLICATION_COMMAND = 2;
    public const REQUEST_TYPE_MESSAGE_COMPONENT = 3;

    public const RESPONSE_TYPE_PONG = 1;
    public const RESPONSE_TYPE_CHANNEL_MESSAGE_WITH_SOURCE = 4;
    public const RESPONSE_TYPE_DEFERRED_CHANNEL_MESSAGE_WITH_SOURCE = 5;
    public const RESPONSE_TYPE_DEFERRED_UPDATE_MESSAGE = 6;
    public const RESPONSE_TYPE_UPDATE_MESSAGE = 7;
    public const RESPONSE_TYPE_APPLICATION_COMMAND_AUTOCOMPLETE_RESULT = 8;
    public const RESPONSE_TYPE_MODAL = 9;

    public const BEHAVIOR_LOAD = 'load';
    public const BEHAVIOR_DEFER = 'defer';

    public abstract function handle(Request $request): DiscordInteractionResponse;
}
