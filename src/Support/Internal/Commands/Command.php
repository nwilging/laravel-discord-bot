<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Internal\Commands;

use Illuminate\Http\Request;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordApiServiceContract;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordInteractionWebhooksServiceContract;
use Nwilging\LaravelDiscordBot\Events\ApplicationCommandInteractionEvent;
use Nwilging\LaravelDiscordBot\Models\WebhookMessage;
use Nwilging\LaravelDiscordBot\Support\Interactions\DiscordInteractionResponse;

abstract class Command
{
    /**
     * The available types of application commands
     * @see https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-types
     */
    public const TYPE_CHAT_INPUT = 1;
    public const TYPE_USER = 2;
    public const TYPE_MESSAGE = 3;

    protected DiscordApiServiceContract  $discordApiService;

    protected DiscordInteractionWebhooksServiceContract $discordInteractionWebhooksService;

    protected ApplicationCommandInteractionEvent $event;

    public function __construct(
        DiscordApiServiceContract $discordApiService,
        DiscordInteractionWebhooksServiceContract $discordInteractionWebhooksService
    )
    {
        $this->discordApiService = $discordApiService;
        $this->discordInteractionWebhooksService = $discordInteractionWebhooksService;
    }

    /**
     * Sets the event context for this command. This should only be called by the CommandManager, calling this method
     * outside of that context may result in unexpected behavior.
     *
     * If this command is instantiated outside of the CommandManager, this method should be called before calling any
     * other methods on this class.
     *
     * @param ApplicationCommandInteractionEvent $event
     * @return void
     */
    public function setEvent(ApplicationCommandInteractionEvent $event): void
    {
        $this->event = $event;
    }

    /**
     * Sends a response to the interaction
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#create-interaction-response
     *
     * @param DiscordInteractionResponse $response
     * @return void
     */
    protected function sendResponse(DiscordInteractionResponse $response): void
    {
        $this->discordInteractionWebhooksService->createInteractionResponse(
            $this->event->getInteractionId(),
            $this->event->getInteractionToken(),
            $response
        );
    }

    /**
     * Gets the original response to the interaction. Functions the same as retrieving a webhook message.
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#get-original-interaction-response
     *
     * @return WebhookMessage
     */
    protected function getOriginalResponse(): WebhookMessage
    {
        return $this->discordInteractionWebhooksService->getInteractionResponse($this->event->getInteractionToken());
    }

    /**
     * Edits the original response to the interaction. Functions the same as editing a webhook message.
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#edit-original-interaction-response
     *
     * @param WebhookMessage $message
     * @return WebhookMessage
     */
    protected function editOriginalResponse(WebhookMessage $message): WebhookMessage
    {
        return $this->discordInteractionWebhooksService->editInteractionResponse(
            $this->event->getInteractionToken(),
            $message
        );
    }

    /**
     * Deletes the original response to the interaction
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#delete-original-interaction-response
     *
     * @return void
     */
    protected function deleteOriginalResponse(): void
    {
        $this->discordInteractionWebhooksService->deleteInteractionResponse($this->event->getInteractionToken());
    }

    /**
     * Creates a followup message for an interaction. Functions the same as executing a webhook.
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#create-followup-message
     *
     * @param WebhookMessage $message
     * @return WebhookMessage
     */
    protected function sendFollowupMessage(WebhookMessage $message): WebhookMessage
    {
        return $this->discordInteractionWebhooksService->createFollowupMessage(
            $this->event->getInteractionToken(),
            $message
        );
    }

    /**
     * Retrieves a followup message for an interaction. Functions the same as retrieving a webhook message.
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#get-followup-message
     *
     * @param string $messageId
     * @return WebhookMessage
     */
    protected function getFollowupMessage(string $messageId): WebhookMessage
    {
        return $this->discordInteractionWebhooksService->getFollowupMessage(
            $this->event->getInteractionToken(),
            $messageId
        );
    }

    /**
     * Edits a followup message for an interaction. Functions the same as editing a webhook message.
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#edit-followup-message
     *
     * @param string $messageId
     * @param WebhookMessage $message
     * @return WebhookMessage
     */
    protected function editFollowupMessage(string $messageId, WebhookMessage $message): WebhookMessage
    {
        return $this->discordInteractionWebhooksService->editFollowupMessage(
            $this->event->getInteractionToken(),
            $messageId,
            $message
        );
    }

    /**
     * Deletes a followup message for an interaction
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#delete-followup-message
     *
     * @param string $messageId
     * @return void
     */
    protected function deleteFollowupMessage(string $messageId): void
    {
        $this->discordInteractionWebhooksService->deleteFollowupMessage(
            $this->event->getInteractionToken(),
            $messageId
        );
    }

    /**
     * Sends a plain text message independently of webhooks. Specify a channel ID to send the message to a
     * different channel, otherwise the message will be sent to the channel the interaction was sent in.
     *
     * @param string $message
     * @param string|null $channelId
     * @return void
     */
    protected function sendPlaintextMessage(string $message, ?string $channelId = null): void
    {
        $this->discordApiService->sendTextMessage(
            $channelId ?? $this->event->getChannelId(),
            $message
        );
    }

    /**
     * Sends a rich text message independently of webhooks. Specify a channel ID to send the message to a
     * different channel, otherwise the message will be sent to the channel the interaction was sent in.
     *
     * @param array $embeds
     * @param array $components
     * @param string|null $channelId
     * @return void
     */
    protected function sendRichMessage(array $embeds, array $components = [], ?string $channelId = null): void
    {
        $this->discordApiService->sendRichTextMessage(
            $channelId ?? $this->event->getChannelId(),
            $embeds,
            $components
        );
    }
}
