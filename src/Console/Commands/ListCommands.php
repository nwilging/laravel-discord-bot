<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Console\Commands;

use Illuminate\Console\Command;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordApplicationCommandServiceContract;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandContract;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandManagerContract;
use Nwilging\LaravelDiscordBot\Support\Command as DiscordCommand;
use Psr\Log\LoggerInterface;

class ListCommands extends Command
{
    protected $signature = 'discord:commands:list';

    protected $description = 'Lists Discord application commands';

    public function handle(CommandManagerContract $commandManager): void
    {
        $commands = $commandManager->all();
        if (empty($commands)) {
            $this->info('No commands exist!');
            return;
        }

        /** @var CommandContract $command */
        foreach ($commands as $command) {
            $this->info(sprintf('`%s` - %s', $command::signature(), $command::description()));
        }
    }
}
