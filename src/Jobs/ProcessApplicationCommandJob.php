<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Jobs;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandManagerContract;
use Nwilging\LaravelDiscordBot\Events\ApplicationCommandInteractionEvent;

class ProcessApplicationCommandJob implements ShouldQueue
{
    protected int $type;

    protected string $signature;

    protected ApplicationCommandInteractionEvent $event;

    public function __construct(int $type, string $signature, ApplicationCommandInteractionEvent $event)
    {
        $this->type = $type;
        $this->signature = $signature;
        $this->event = $event;
    }

    public function handle(CommandManagerContract $commandManager, Application $laravel): void
    {
        $command = $commandManager->get($this->type, $this->signature);
        if (method_exists($command, 'handle')) {
            $command->setEvent($this->event);
            $laravel->call([$command, 'handle']);
        }
    }
}
