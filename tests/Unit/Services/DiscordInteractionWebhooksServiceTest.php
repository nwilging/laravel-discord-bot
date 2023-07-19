<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Services;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Mockery\MockInterface;
use Nwilging\LaravelDiscordBot\Models\WebhookMessage;
use Nwilging\LaravelDiscordBot\Services\DiscordInteractionWebhooksService;
use Nwilging\LaravelDiscordBot\Support\Interactions\DiscordInteractionResponse;
use Nwilging\LaravelDiscordBotTests\TestCase;

class DiscordInteractionWebhooksServiceTest extends TestCase
{
    protected string $applicationId = 'test-app-id';

    protected string $token = 'test-token';

    protected string $apiUrl = 'https://example.com';

    protected MockInterface $httpClient;

    protected DiscordInteractionWebhooksService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->httpClient = \Mockery::mock(ClientInterface::class);
        $this->service = new DiscordInteractionWebhooksService(
            $this->applicationId,
            $this->token,
            $this->apiUrl,
            $this->httpClient
        );
    }

    public function testCreateInteractionResponse()
    {
        $interactionId = '12345';
        $interactionToken = 'test-token';
        $response = \Mockery::mock(DiscordInteractionResponse::class);

        $array = [];
        $response->shouldReceive('toArray')->andReturn($array);

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with(
                Request::METHOD_POST,
                sprintf('%s/interactions/%s/%s/callback', $this->apiUrl, $interactionId, $interactionToken), [
                    'headers' => [
                        'Authorization' => sprintf('Bot %s', $this->token),
                    ],
                    'json' => $array,
                ]
            );

        $this->service->createInteractionResponse($interactionId, $interactionToken, $response);
    }

    public function testGetInteractionResponse()
    {
        $interactionToken = 'test-token';

        $response = new Response(200, [], json_encode([
            'id' => '12345',
        ]));

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with(
                Request::METHOD_GET,
                sprintf('%s/webhooks/%s/%s/messages/@original', $this->apiUrl, $this->applicationId, $interactionToken), [
                    'headers' => [
                        'Authorization' => sprintf('Bot %s', $this->token),
                    ],
                    'json' => [],
                ]
            )->andReturn($response);

        $result = $this->service->getInteractionResponse($interactionToken);
        $this->assertInstanceOf(WebhookMessage::class, $result);
    }

    public function testEditInteractionResponse()
    {
        $interactionToken = 'test-token';

        $message = \Mockery::mock(WebhookMessage::class);
        $message->shouldReceive('toArray')->andReturn([]);

        $response = new Response(200, [], json_encode([
            'id' => '12345',
        ]));

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with(
                Request::METHOD_PATCH,
                sprintf('%s/webhooks/%s/%s/messages/@original', $this->apiUrl, $this->applicationId, $interactionToken), [
                    'headers' => [
                        'Authorization' => sprintf('Bot %s', $this->token),
                    ],
                    'json' => [],
                ]
            )->andReturn($response);

        $result = $this->service->editInteractionResponse($interactionToken, $message);
        $this->assertInstanceOf(WebhookMessage::class, $result);
    }

    public function testDeleteInteractionResponse()
    {
        $interactionToken = 'test-token';
        $this->httpClient->shouldReceive('request')
            ->once()
            ->with(
                Request::METHOD_DELETE,
                sprintf('%s/webhooks/%s/%s/messages/@original', $this->apiUrl, $this->applicationId, $interactionToken), [
                    'headers' => [
                        'Authorization' => sprintf('Bot %s', $this->token),
                    ],
                    'json' => [],
                ]
            );

        $this->service->deleteInteractionResponse($interactionToken);
    }

    public function testCreateFollowupMessage()
    {
        $interactionToken = 'test-token';

        $message = \Mockery::mock(WebhookMessage::class);
        $message->shouldReceive('toArray')->andReturn([]);

        $response = new Response(200, [], json_encode([
            'id' => '12345',
        ]));

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with(
                Request::METHOD_POST,
                sprintf('%s/webhooks/%s/%s', $this->apiUrl, $this->applicationId, $interactionToken), [
                    'headers' => [
                        'Authorization' => sprintf('Bot %s', $this->token),
                    ],
                    'json' => [],
                ]
            )->andReturn($response);

        $result = $this->service->createFollowupMessage($interactionToken, $message);
        $this->assertInstanceOf(WebhookMessage::class, $result);
    }

    public function testGetFollowupMessage()
    {
        $interactionToken = 'test-token';
        $messageId = 'test-message-id';

        $response = new Response(200, [], json_encode([
            'id' => '12345',
        ]));

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with(
                Request::METHOD_GET,
                sprintf('%s/webhooks/%s/%s/messages/%s', $this->apiUrl, $this->applicationId, $interactionToken, $messageId), [
                    'headers' => [
                        'Authorization' => sprintf('Bot %s', $this->token),
                    ],
                    'json' => [],
                ]
            )->andReturn($response);

        $result = $this->service->getFollowupMessage($interactionToken, $messageId);
        $this->assertInstanceOf(WebhookMessage::class, $result);
    }

    public function testEditFollowupMessage()
    {
        $interactionToken = 'test-token';
        $messageId = 'test-message-id';

        $message = \Mockery::mock(WebhookMessage::class);
        $message->shouldReceive('toArray')->andReturn([]);

        $response = new Response(200, [], json_encode([
            'id' => '12345',
        ]));

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with(
                Request::METHOD_PATCH,
                sprintf('%s/webhooks/%s/%s/messages/%s', $this->apiUrl, $this->applicationId, $interactionToken, $messageId), [
                    'headers' => [
                        'Authorization' => sprintf('Bot %s', $this->token),
                    ],
                    'json' => [],
                ]
            )->andReturn($response);

        $result = $this->service->editFollowupMessage($interactionToken, $messageId, $message);
        $this->assertInstanceOf(WebhookMessage::class, $result);
    }

    public function testDeleteFollowupMessage()
    {
        $interactionToken = 'test-token';
        $messageId = 'test-message-id';

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with(
                Request::METHOD_DELETE,
                sprintf('%s/webhooks/%s/%s/messages/%s', $this->apiUrl, $this->applicationId, $interactionToken, $messageId), [
                    'headers' => [
                        'Authorization' => sprintf('Bot %s', $this->token),
                    ],
                    'json' => [],
                ]
            );

        $this->service->deleteFollowupMessage($interactionToken, $messageId);
    }
}
