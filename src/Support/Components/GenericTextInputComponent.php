<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Components;

use Nwilging\LaravelDiscordBot\Support\Component;
use Nwilging\LaravelDiscordBot\Support\Traits\FiltersRecursive;

abstract class GenericTextInputComponent extends Component
{
    use FiltersRecursive;

    public const STYLE_SHORT = 1;
    public const STYLE_PARAGRAPH = 2;

    protected int $style;

    protected string $label;

    protected ?int $minLength = null;

    protected ?int $maxLength = null;

    protected ?bool $required = null;

    protected ?string $value = null;

    protected ?string $placeholder = null;

    public function __construct(int $style, string $label, string $customId = null)
    {
        parent::__construct($customId);

        $this->style = $style;
        $this->label = $label;
    }

    /**
     * The minimum input length for a text input, min 0, max 4000
     *
     * @see https://discord.com/developers/docs/interactions/message-components#text-inputs-text-input-structure
     * @param int $minLength
     * @return $this
     */
    public function withMinLength(int $minLength): self
    {
        $this->minLength = $minLength;
        return $this;
    }

    /**
     * The maximum input length for a text input, min 1, max 4000
     *
     * @see https://discord.com/developers/docs/interactions/message-components#text-inputs-text-input-structure
     * @param int $maxLength
     * @return $this
     */
    public function withMaxLength(int $maxLength): self
    {
        $this->maxLength = $maxLength;
        return $this;
    }

    /**
     * Custom placeholder text if the input is empty, max 100 characters
     *
     * @see https://discord.com/developers/docs/interactions/message-components#text-inputs-text-input-structure
     * @param string $placeholder
     * @return $this
     */
    public function withPlaceholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * A pre-filled value for this component, max 4000 characters
     *
     * @see https://discord.com/developers/docs/interactions/message-components#text-inputs-text-input-structure
     * @param string $value
     * @return $this
     */
    public function withValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Whether this component is required to be filled, default true
     *
     * @see https://discord.com/developers/docs/interactions/message-components#text-inputs-text-input-structure
     * @param bool $required
     * @return $this
     */
    public function required(bool $required = true): self
    {
        $this->required = $required;
        return $this;
    }

    public function getType(): int
    {
        return static::TYPE_TEXT_INPUT;
    }

    /**
     * Returns a Discord-API compatible text input array
     *
     * @see https://discord.com/developers/docs/interactions/message-components#text-inputs-text-input-structure
     * @return array
     */
    public function toArray(): array
    {
        return $this->arrayFilterRecursive([
            'type' => $this->getType(),
            'custom_id' => $this->customId,
            'style' => $this->style,
            'label' => $this->label,
            'min_length' => $this->minLength,
            'max_length' => $this->maxLength,
            'required' => $this->required,
            'value' => $this->value,
            'placeholder' => $this->placeholder,
        ]);
    }
}
