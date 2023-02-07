<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Commands\Options;

use Nwilging\LaravelDiscordBot\Support\Commands\CommandOption;
use Nwilging\LaravelDiscordBot\Support\Traits\ApplicationCommand\HasAutoComplete;
use Nwilging\LaravelDiscordBot\Support\Traits\ApplicationCommand\HasChoices;
use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

class NumberOption extends CommandOption
{
    use HasChoices, HasAutoComplete, MergesArrays;

    protected ?float $minValue = null;

    protected ?float $maxValue = null;


    public function getType(): int
    {
        return static::TYPE_NUMBER;
    }

    protected function choiceTransformer(OptionChoice $choice): array
    {
        $array = $choice->toArray();
        $array['value'] = (float) $array['value'];

        return $array;
    }

    public function toArray(): array
    {
        $merge = $this->mergeChoices([]);
        $merge = $this->mergeAutocomplete($merge);

        return $this->toMergedArray(array_merge($merge, [
            'min_value' => $this->minValue,
            'max_value' => $this->maxValue,
        ]));
    }
}
