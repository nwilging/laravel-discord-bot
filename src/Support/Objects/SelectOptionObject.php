<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Objects;

use Nwilging\LaravelDiscordBot\Support\SupportObject;
use Nwilging\LaravelDiscordBot\Support\Traits\HasEmojiObject;
use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

/**
 * Select Option Object
 * @see https://discord.com/developers/docs/interactions/message-components#select-menu-object-select-option-structure
 */
class SelectOptionObject extends SupportObject
{
    use MergesArrays, HasEmojiObject;

    protected string $label;

    protected string $value;

    protected ?string $description = null;

    protected ?bool $default = null;

    public function __construct(string $label, string $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * An additional description of the option, max 100 characters
     *
     * @see https://discord.com/developers/docs/interactions/message-components#select-menu-object-select-option-structure
     * @param string $description
     * @return $this
     */
    public function withDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Will render this option as selected by default
     *
     * @see https://discord.com/developers/docs/interactions/message-components#select-menu-object-select-option-structure
     * @param bool $default
     * @return $this
     */
    public function default(bool $default = true): self
    {
        $this->default = $default;
        return $this;
    }

    /**
     * Returns a Discord-API compliant select option array
     *
     * @see https://discord.com/developers/docs/interactions/message-components#select-menu-object-select-option-structure
     * @return array
     */
    public function toArray(): array
    {
        return $this->toMergedArray($this->mergeEmojiObject([
            'label' => $this->label,
            'value' => $this->value,
            'description' => $this->description,
            'default' => $this->default,
        ]));
    }
}
