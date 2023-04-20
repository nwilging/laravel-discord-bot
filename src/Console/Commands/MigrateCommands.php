<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordApplicationCommandServiceContract;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandContract;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandManagerContract;
use Nwilging\LaravelDiscordBot\Support\Command as DiscordCommand;
use Psr\Log\LoggerInterface;

class MigrateCommands extends Command
{
    protected $signature = 'discord:commands:migrate';

    protected $description = 'Migrates Discord application commands';

    public function handle(
        CommandManagerContract $commandManager,
        DiscordApplicationCommandServiceContract $applicationCommandService,
        LoggerInterface $log
    ): void {
        $types = $commandManager->all();
        if (empty($types)) {
            $this->info('No commands to migrate!');
            return;
        }

        $commands = Arr::flatten($types);
        $this->info(sprintf('Migrating %d commands', count($commands)));

        /** @var CommandContract|string $command */
        foreach ($commands as $command) {
            $this->info(sprintf('Migrating: `%s` (%s)', $command::signature(), $command));
            $class = $command::migrate();

            $closure = ($command::guildId() !== null)
                ? function (DiscordCommand $discordCommand) use ($command, $applicationCommandService): array {
                    return $applicationCommandService->createGuildCommand($command::guildId(), $discordCommand);
                } : function (DiscordCommand $discordCommand) use ($applicationCommandService): array {
                    return $applicationCommandService->createGlobalCommand($discordCommand);
                };

            try {
                $closure($class);
            } catch (\Exception $exception) {
                $this->error(sprintf('Error when migrating `%s`: %s', $command::signature(), $exception->getMessage()));
                $log->error($exception->getMessage(), [
                    'exception' => $exception,
                ]);

                continue;
            }

            $this->info(sprintf('Migrated: %s', $command::signature()));
        }

        $this->info('Migration complete!');
    }
}
