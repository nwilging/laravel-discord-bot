<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Providers;

use Illuminate\Support\ServiceProvider;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandManagerContract;
use Nwilging\LaravelDiscordBot\Support\Internal\Commands\CommandManager;

class DiscordApplicationCommandServiceProvider extends ServiceProvider
{
    protected array $commands = [];

    public function register()
    {
        $this->app->singleton(CommandManagerContract::class, CommandManager::class);

        /** @var CommandManagerContract $manager */
        $manager = $this->app->make(CommandManagerContract::class);
        foreach ($this->commands as $command) {
            $manager->register($command);
        }
    }
}
