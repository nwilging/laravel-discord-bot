<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Services;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Mockery\MockInterface;
use Nwilging\LaravelDiscordBot\Services\DiscordApplicationCommandService;
use Nwilging\LaravelDiscordBot\Support\Command;
use Nwilging\LaravelDiscordBotTests\TestCase;

class DiscordApplicationCommandServiceTest extends TestCase
{
    protected string $applicationId = 'test-app-id';

    protected string $token = 'test-token';

    protected string $apiUrl = 'https://example.com';

    protected MockInterface $httpClient;

    protected DiscordApplicationCommandService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->httpClient = \Mockery::mock(ClientInterface::class);
        $this->service = new DiscordApplicationCommandService(
            $this->applicationId,
            $this->token,
            $this->apiUrl,
            $this->httpClient
        );
    }

    public function testCreateGlobalCommand()
    {
        $expectedCommandArray = [
            'key' => 'value',
        ];

        $expectedUrl = 'https://example.com/applications/test-app-id/commands';

        $command = \Mockery::mock(Command::class);
        $command->shouldReceive('toArray')
            ->once()
            ->andReturn($expectedCommandArray);

        $responseBody = [
            'response' => 'value',
        ];

        $response = new Response(201, [], json_encode($responseBody));

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with(Request::METHOD_POST, $expectedUrl, [
                'headers' => [
                    'Authorization' => 'Bot ' . $this->token,
                ],
                'json' => $expectedCommandArray,
            ])->andReturn($response);

        $result = $this->service->createGlobalCommand($command);
        $this->assertEquals($responseBody, $result);
    }

    public function testCreateGuildCommand()
    {
        $guildId = 'test-guild-id';
        $expectedCommandArray = [
            'key' => 'value',
        ];

        $expectedUrl = 'https://example.com/applications/test-app-id/guilds/test-guild-id/commands';

        $command = \Mockery::mock(Command::class);
        $command->shouldReceive('toArray')
            ->once()
            ->andReturn($expectedCommandArray);

        $responseBody = [
            'response' => 'value',
        ];

        $response = new Response(201, [], json_encode($responseBody));

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with(Request::METHOD_POST, $expectedUrl, [
                'headers' => [
                    'Authorization' => 'Bot ' . $this->token,
                ],
                'json' => $expectedCommandArray,
            ])->andReturn($response);

        $result = $this->service->createGuildCommand($guildId, $command);
        $this->assertEquals($responseBody, $result);
    }

    public function testDeleteGlobalCommand()
    {
        $commandId = 'test-command-id';
        $expectedUrl = 'https://example.com/applications/test-app-id/commands/test-command-id';

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with(Request::METHOD_DELETE, $expectedUrl, [
                'headers' => [
                    'Authorization' => 'Bot ' . $this->token,
                ],
                'json' => [],
            ]);

        $this->service->deleteGlobalCommand($commandId);
    }

    public function testDeleteGuildCommand()
    {
        $commandId = 'test-command-id';
        $guildId = 'test-guild-id';
        $expectedUrl = 'https://example.com/applications/test-app-id/guilds/test-guild-id/commands/test-command-id';

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with(Request::METHOD_DELETE, $expectedUrl, [
                'headers' => [
                    'Authorization' => 'Bot ' . $this->token,
                ],
                'json' => [],
            ]);

        $this->service->deleteGuildCommand($guildId, $commandId);
    }

    public function testUpdateGlobalCommand()
    {
        $commandId = 'test-command-id';
        $expectedCommandArray = [
            'key' => 'value',
        ];

        $expectedUrl = 'https://example.com/applications/test-app-id/commands/test-command-id';

        $command = \Mockery::mock(Command::class);
        $command->shouldReceive('toArray')
            ->once()
            ->andReturn($expectedCommandArray);

        $responseBody = [
            'response' => 'value',
        ];

        $response = new Response(201, [], json_encode($responseBody));

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with(Request::METHOD_PATCH, $expectedUrl, [
                'headers' => [
                    'Authorization' => 'Bot ' . $this->token,
                ],
                'json' => $expectedCommandArray,
            ])->andReturn($response);

        $result = $this->service->updateGlobalCommand($commandId, $command);
        $this->assertEquals($responseBody, $result);
    }

    public function testUpdateGuildCommand()
    {
        $guildId = 'test-guild-id';
        $commandId = 'test-command-id';
        $expectedCommandArray = [
            'key' => 'value',
        ];

        $expectedUrl = 'https://example.com/applications/test-app-id/guilds/test-guild-id/commands/test-command-id';

        $command = \Mockery::mock(Command::class);
        $command->shouldReceive('toArray')
            ->once()
            ->andReturn($expectedCommandArray);

        $responseBody = [
            'response' => 'value',
        ];

        $response = new Response(201, [], json_encode($responseBody));

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with(Request::METHOD_PATCH, $expectedUrl, [
                'headers' => [
                    'Authorization' => 'Bot ' . $this->token,
                ],
                'json' => $expectedCommandArray,
            ])->andReturn($response);

        $result = $this->service->updateGuildCommand($guildId, $commandId, $command);
        $this->assertEquals($responseBody, $result);
    }
}
