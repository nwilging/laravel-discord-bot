<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Traits\ApplicationCommand;

trait HasAutoComplete
{
    protected ?bool $autocomplete = null;

    public function autocomplete(bool $autocomplete = true): self
    {
        $this->autocomplete = $autocomplete;
        return $this;
    }

    protected function mergeAutocomplete(array $merge): array
    {
        return array_merge($merge, array_filter([
            'autocomplete' => $this->autocomplete,
        ]));
    }
}
