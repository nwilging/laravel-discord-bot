<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Commands\Options;

use Nwilging\LaravelDiscordBot\Support\Commands\CommandOption;
use Nwilging\LaravelDiscordBot\Support\Traits\ApplicationCommand\NoChoiceTransformer;

class SubCommandOption extends CommandOption
{
    use NoChoiceTransformer;

    public function getType(): int
    {
        return static::TYPE_SUB_COMMAND;
    }
}
