<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Contracts\Services;

use Nwilging\LaravelDiscordBot\Support\Command;

interface DiscordApplicationCommandServiceContract
{
    /**
     * Creates a global command
     *
     * @see https://discord.com/developers/docs/interactions/application-commands#making-a-global-command
     *
     * @param Command $command
     * @return array
     */
    public function createGlobalCommand(Command $command): array;

    /**
     * Updates a global command
     *
     * @see https://discord.com/developers/docs/interactions/application-commands#updating-and-deleting-a-command
     *
     * @param string $commandId
     * @param Command $command
     * @return array
     */
    public function updateGlobalCommand(string $commandId, Command $command): array;

    /**
     * Creates a command specific to a guild (server)
     *
     * @see https://discord.com/developers/docs/interactions/application-commands#making-a-guild-command
     *
     * @param string $guildId
     * @param Command $command
     * @return array
     */
    public function createGuildCommand(string $guildId, Command $command): array;

    /**
     * Updates a command specific to a guild (server)
     *
     * @see https://discord.com/developers/docs/interactions/application-commands#updating-and-deleting-a-command
     *
     * @param string $guildId
     * @param string $commandId
     * @param Command $command
     * @return array
     */
    public function updateGuildCommand(string $guildId, string $commandId, Command $command): array;

    /**
     * Deletes a global command
     *
     * @see https://discord.com/developers/docs/interactions/application-commands#updating-and-deleting-a-command
     *
     * @param string $commandId
     * @return void
     */
    public function deleteGlobalCommand(string $commandId): void;

    /**
     * Deletes a command specific to a guild (server)
     *
     * @see https://discord.com/developers/docs/interactions/application-commands#updating-and-deleting-a-command
     *
     * @param string $guildId
     * @param string $commandId
     * @return void
     */
    public function deleteGuildCommand(string $guildId, string $commandId): void;
}
