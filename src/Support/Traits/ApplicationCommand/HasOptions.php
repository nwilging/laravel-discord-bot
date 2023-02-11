<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Traits\ApplicationCommand;

use Nwilging\LaravelDiscordBot\Support\Commands\CommandOption;

trait HasOptions
{
    /**
     * @var CommandOption[]|null
     */
    protected ?array $options = null;

    public function option(CommandOption $option): self
    {
        if (is_null($this->options)) {
            $this->options = [];
        }

        $this->options[] = $option;
        return $this;
    }

    protected function mergeOptions(array $merge = []): array
    {
        if (empty($this->options)) {
            return $merge;
        }

        return array_merge($merge, array_filter([
            'options' => array_map(function (CommandOption $option): array {
                return $option->toArray();
            }, $this->options),
        ]));
    }
}
