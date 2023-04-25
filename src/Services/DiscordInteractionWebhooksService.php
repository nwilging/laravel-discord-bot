<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Services;

use GuzzleHttp\ClientInterface;
use Illuminate\Http\Request;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordInteractionWebhooksServiceContract;
use Nwilging\LaravelDiscordBot\Models\WebhookMessage;
use Nwilging\LaravelDiscordBot\Support\Interactions\DiscordInteractionResponse;
use Nwilging\LaravelDiscordBot\Support\Traits\DiscordApiService as IsApiService;

class DiscordInteractionWebhooksService implements DiscordInteractionWebhooksServiceContract
{
    use IsApiService;

    protected string $applicationId;

    public function __construct(string $applicationId, string $token, string $apiUrl, ClientInterface $httpClient)
    {
        $this->applicationId = $applicationId;
        $this->token = $token;
        $this->apiUrl = $apiUrl;
        $this->httpClient = $httpClient;
    }

    public function createInteractionResponse(string $interactionId, string $interactionToken, DiscordInteractionResponse $response): void
    {
        $this->makeRequest(
            Request::METHOD_POST,
            sprintf('interactions/%s/%s/callback', $interactionId, $interactionToken),
            $response->toArray()
        );
    }

    public function getInteractionResponse(string $interactionToken): WebhookMessage
    {
        $response = $this->makeRequest(
            Request::METHOD_GET,
            sprintf('webhooks/%s/%s/messages/@original', $this->applicationId, $interactionToken)
        );

        return $this->messageResponseToDomainModel(json_decode($response->getBody()->getContents()));
    }

    public function editInteractionResponse(string $interactionToken, WebhookMessage $message): WebhookMessage
    {
        $response = $this->makeRequest(
            Request::METHOD_PATCH,
            sprintf('webhooks/%s/%s/messages/@original', $this->applicationId, $interactionToken),
            $message->toArray()
        );

        return $this->messageResponseToDomainModel(json_decode($response->getBody()->getContents()));
    }

    public function deleteInteractionResponse(string $interactionToken): void
    {
        $this->makeRequest(
            Request::METHOD_DELETE,
            sprintf('webhooks/%s/%s/messages/@original', $this->applicationId, $interactionToken)
        );
    }

    public function createFollowupMessage(string $interactionToken, WebhookMessage $message): WebhookMessage
    {
        $response = $this->makeRequest(
            Request::METHOD_POST,
            sprintf('webhooks/%s/%s', $this->applicationId, $interactionToken),
            $message->toArray()
        );

        $model = $this->messageResponseToDomainModel(json_decode($response->getBody()->getContents()));

        // Wait is always true for interaction webhook executions
        $model->wait = true;
        return $model;
    }

    public function getFollowupMessage(string $interactionToken, string $messageId): WebhookMessage
    {
        $response = $this->makeRequest(
            Request::METHOD_GET,
            sprintf('webhooks/%s/%s/messages/%s', $this->applicationId, $interactionToken, $messageId)
        );

        return $this->messageResponseToDomainModel(json_decode($response->getBody()->getContents()));
    }

    public function editFollowupMessage(string $interactionToken, string $messageId, WebhookMessage $message): WebhookMessage
    {
        $response = $this->makeRequest(
            Request::METHOD_PATCH,
            sprintf('webhooks/%s/%s/messages/%s', $this->applicationId, $interactionToken, $messageId),
            $message->toArray()
        );

        return $this->messageResponseToDomainModel(json_decode($response->getBody()->getContents()));
    }

    public function deleteFollowupMessage(string $interactionToken, string $messageId): void
    {
        $this->makeRequest(
            Request::METHOD_DELETE,
            sprintf('webhooks/%s/%s/messages/%s', $this->applicationId, $interactionToken, $messageId)
        );
    }

    protected function messageResponseToDomainModel(\stdClass $message): WebhookMessage
    {
        $model = new WebhookMessage();
        return $model;
    }
}