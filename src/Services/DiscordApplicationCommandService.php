<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Services;

use GuzzleHttp\ClientInterface;
use Illuminate\Http\Request;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordApplicationCommandServiceContract;
use Nwilging\LaravelDiscordBot\Support\Command;
use Nwilging\LaravelDiscordBot\Support\Traits\DiscordApiService as IsApiService;

class DiscordApplicationCommandService implements DiscordApplicationCommandServiceContract
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

    public function createGlobalCommand(Command $command): array
    {
        $response = $this->makeRequest(
            Request::METHOD_POST,
            sprintf('applications/%s/commands', $this->applicationId),
            $command->toArray(),
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function createGuildCommand(string $guildId, Command $command): array
    {
        $response = $this->makeRequest(
            Request::METHOD_POST,
            sprintf('applications/%s/guilds/%s/commands', $this->applicationId, $guildId),
            $command->toArray(),
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function deleteGlobalCommand(string $commandId): void
    {
        $this->makeRequest(
            Request::METHOD_DELETE,
            sprintf('applications/%s/commands/%s', $this->applicationId, $commandId)
        );
    }

    public function deleteGuildCommand(string $guildId, string $commandId): void
    {
        $this->makeRequest(
            Request::METHOD_DELETE,
            sprintf('applications/%s/guilds/%s/commands/%s', $this->applicationId, $guildId, $commandId)
        );
    }

    public function updateGlobalCommand(string $commandId, Command $command): array
    {
        $response = $this->makeRequest(
            Request::METHOD_PATCH,
            sprintf('applications/%s/commands/%s', $this->applicationId, $commandId),
            $command->toArray()
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function updateGuildCommand(string $guildId, string $commandId, Command $command): array
    {
        $response = $this->makeRequest(
            Request::METHOD_PATCH,
            sprintf('applications/%s/guilds/%s/commands/%s', $this->applicationId, $guildId, $commandId),
            $command->toArray()
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}
