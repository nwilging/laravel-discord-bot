<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Traits\ApplicationCommand;

use Nwilging\LaravelDiscordBot\Support\Commands\Options\OptionChoice;

trait HasChoices
{
    /**
     * @var OptionChoice[]|null
     */
    protected ?array $choices = null;

    public function choice(OptionChoice $choice): self
    {
        if (is_null($this->choices)) {
            $this->choices = [];
        }

        $this->choices[] = $choice;
        return $this;
    }

    public function choices(array $choices): self
    {
        $this->choices = $choices;
        return $this;
    }

    protected function mergeChoices(array $merge): array
    {
        if (empty($this->choices)) {
            return $merge;
        }

        return array_merge($merge, [
            'choices' => array_map(function (OptionChoice $choice): array {
                return $this->choiceTransformer($choice);
            }, $this->choices)
        ]);
    }
}
