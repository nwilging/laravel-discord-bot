<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands;

interface CommandManagerContract
{
    public function register(string $commandClass): void;

    public function get(int $type, string $signature): CommandContract;

    public function all(): array;
}
