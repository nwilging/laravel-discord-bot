<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands;

use Nwilging\LaravelDiscordBot\Support\Command;

interface CommandContract
{
    public static function signature(): string;

    public static function description(): string;

    public static function guildId(): ?string;

    public static function type(): int;

    public static function migrate(): Command;
}
