<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Commands\Options;

use Illuminate\Contracts\Support\Arrayable;
use Nwilging\LaravelDiscordBot\Support\Traits\FiltersRecursive;

/**
 * Application Command Option Choice
 * @see https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-choice-structure
 */
class OptionChoice implements Arrayable
{
    use FiltersRecursive;

    protected string $name;

    protected ?array $nameLocalizations = null;

    protected string $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function nameLocalizations(array $localizations): self
    {
        $this->nameLocalizations = $localizations;
        return $this;
    }

    public function toArray(): array
    {
        return $this->arrayFilterRecursive([
            'name' => $this->name,
            'name_localizations' => $this->nameLocalizations,
            'value' => $this->value,
        ]);
    }
}
