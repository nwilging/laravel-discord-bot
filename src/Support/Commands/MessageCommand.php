<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Commands;

use Nwilging\LaravelDiscordBot\Support\Command;
use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

class MessageCommand extends Command
{
    use MergesArrays;

    public function getType(): int
    {
        return static::TYPE_MESSAGE;
    }
}
