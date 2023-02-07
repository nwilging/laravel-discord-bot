<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Contracts\Services;

use Nwilging\LaravelDiscordBot\Support\Command;

interface DiscordApplicationCommandServiceContract
{
    public function createGlobalCommand(Command $command): array;

    public function createGuildCommand(string $guildId, Command $command): array;

    public function deleteGlobalCommand(string $commandId): void;

    public function deleteGuildCommand(string $guildId, string $commandId): void;
}
