<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Contracts\Services;

use Nwilging\LaravelDiscordBot\Models\WebhookMessage;
use Nwilging\LaravelDiscordBot\Support\Interactions\DiscordInteractionResponse;

interface DiscordInteractionWebhooksServiceContract
{
    /**
     * Creates a response to an interaction from the gateway.
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#create-interaction-response
     *
     * @param string $interactionId
     * @param string $interactionToken
     * @param DiscordInteractionResponse $response
     * @return void
     */
    public function createInteractionResponse(
        string $interactionId,
        string $interactionToken,
        DiscordInteractionResponse $response
    ): void;

    /**
     * Returns the initial interaction response.
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#get-original-interaction-response
     *
     * @param string $interactionToken
     * @return WebhookMessage
     */
    public function getInteractionResponse(string $interactionToken): WebhookMessage;

    /**
     * Edits the initial interaction response.
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#edit-original-interaction-response
     *
     * @param string $interactionToken
     * @param WebhookMessage $message
     * @return WebhookMessage
     */
    public function editInteractionResponse(string $interactionToken, WebhookMessage $message): WebhookMessage;

    /**
     * Deletes the initial interaction response.
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#delete-original-interaction-response
     *
     * @param string $interactionToken
     * @return void
     */
    public function deleteInteractionResponse(string $interactionToken): void;

    /**
     * Creates a followup message for an interaction.
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#create-followup-message
     *
     * @param string $interactionToken
     * @param WebhookMessage $message
     * @return WebhookMessage
     */
    public function createFollowupMessage(string $interactionToken, WebhookMessage $message): WebhookMessage;

    /**
     * Returns a followup message for an interaction.
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#get-followup-message
     *
     * @param string $interactionToken
     * @param string $messageId
     * @return WebhookMessage
     */
    public function getFollowupMessage(string $interactionToken, string $messageId): WebhookMessage;

    /**
     * Edits a followup message for an interaction.
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#edit-followup-message
     *
     * @param string $interactionToken
     * @param string $messageId
     * @param WebhookMessage $message
     * @return WebhookMessage
     */
    public function editFollowupMessage(string $interactionToken, string $messageId, WebhookMessage $message): WebhookMessage;

    /**
     * Deletes a followup message for an interaction.
     *
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#delete-followup-message
     *
     * @param string $interactionToken
     * @param string $messageId
     * @return void
     */
    public function deleteFollowupMessage(string $interactionToken, string $messageId): void;
}
