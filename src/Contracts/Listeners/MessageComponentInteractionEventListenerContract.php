<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Contracts\Listeners;

use Nwilging\LaravelDiscordBot\Events\MessageComponentInteractionEvent;
use Nwilging\LaravelDiscordBot\Support\Interactions\InteractionHandler;

interface MessageComponentInteractionEventListenerContract
{
    public const LOAD_WHILE_HANDLING = InteractionHandler::RESPONSE_TYPE_DEFERRED_CHANNEL_MESSAGE_WITH_SOURCE;
    public const DEFER_WHILE_HANDLING = InteractionHandler::RESPONSE_TYPE_DEFERRED_UPDATE_MESSAGE;
    public const REPLY_TO_MESSAGE = InteractionHandler::RESPONSE_TYPE_CHANNEL_MESSAGE_WITH_SOURCE;

    /**
     * Optional message to reply to the interaction with. If a string is returned the bot will reply with
     * the given message to the interaction immediately. You may still handle this event asynchronously in your
     * application.
     *
     * If this method returns null, no reply will be made.
     *
     * @param MessageComponentInteractionEvent $event
     * @return string|null
     */
    public function replyContent(MessageComponentInteractionEvent $event): ?string;

    /**
     * The behavior of the bot immediately upon the interaction. This may be LOAD_WHILE_HANDLING
     * or DEFER_WHILE_HANDLING. Loading will show a loading message such as "bot is thinking..." until
     * your application makes a followup message.
     *
     * Deferring will show no loading message. Your application may still handle the event asynchronously.
     *
     * @param MessageComponentInteractionEvent $event
     * @return int
     */
    public function behavior(MessageComponentInteractionEvent $event): int;
}
