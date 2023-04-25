<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Internal\Commands;

use Illuminate\Contracts\Foundation\Application;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandContract;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandManagerContract;

class CommandManager implements CommandManagerContract
{
    protected Application $laravel;

    protected array $commands = [
        Command::TYPE_CHAT_INPUT => [],
        Command::TYPE_USER => [],
        Command::TYPE_MESSAGE => [],
    ];

    public function __construct(Application $laravel)
    {
        $this->laravel = $laravel;
    }

    public function register(string $commandClass): void
    {
        $this->validate($commandClass);
        /** @var CommandContract $commandClass */
        $this->commands[$commandClass::type()][$commandClass::signature()] = $commandClass;
    }

    public function get(int $type, string $signature): CommandContract
    {
        if (!array_key_exists($type, $this->commands) || !array_key_exists($signature, $this->commands[$type])) {
            throw new \InvalidArgumentException(sprintf('Invalid command: %s', $signature));
        }

        return $this->laravel->make($this->commands[$type][$signature]);
    }

    public function all(): array
    {
        return $this->commands;
    }

    protected function validate(string $class): void
    {
        $error = sprintf('%s is not a valid command class', $class);
        if (!method_exists($class, 'signature')) {
            throw new \RuntimeException(sprintf('%s: missing method `signature`', $error));
        }

        if (!method_exists($class, 'description')) {
            throw new \RuntimeException(sprintf('%s: missing method `description`', $error));
        }
    }
}
