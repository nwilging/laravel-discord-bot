<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Commands;

use Nwilging\LaravelDiscordBot\Support\Command;
use Nwilging\LaravelDiscordBot\Support\Traits\ApplicationCommand\HasOptions;
use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

class SlashCommand extends Command
{
    use MergesArrays, HasOptions;

    protected string $description;

    public function __construct(string $name, string $description)
    {
        parent::__construct($name);
        $this->description = $description;
    }

    public function getType(): int
    {
        return static::TYPE_CHAT_INPUT;
    }

    public function toArray(): array
    {
        return $this->toMergedArray($this->mergeOptions([
            'description' => $this->description,
        ]));
    }
}
