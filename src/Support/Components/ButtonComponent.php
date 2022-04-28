<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Components;

use Nwilging\LaravelDiscordBot\Support\Component;
use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

/**
 * Action Button Component
 * @see https://discord.com/developers/docs/interactions/message-components#buttons
 */
class ButtonComponent extends GenericButtonComponent
{
    use MergesArrays;

    public function __construct(string $label, string $customId)
    {
        parent::__construct(static::STYLE_PRIMARY, $label, $customId);
    }

    /**
     * Sets the button style to primary
     *
     * @see https://discord.com/developers/docs/interactions/message-components#button-object-button-styles
     * @return $this
     */
    public function withPrimaryStyle(): self
    {
        $this->style = static::STYLE_PRIMARY;
        return $this;
    }

    /**
     * Sets the button style to secondary
     *
     * @see https://discord.com/developers/docs/interactions/message-components#button-object-button-styles
     * @return $this
     */
    public function withSecondaryStyle(): self
    {
        $this->style = static::STYLE_SECONDARY;
        return $this;
    }

    /**
     * Sets the button style to success
     *
     * @see https://discord.com/developers/docs/interactions/message-components#button-object-button-styles
     * @return $this
     */
    public function withSuccessStyle(): self
    {
        $this->style = static::STYLE_SUCCESS;
        return $this;
    }

    /**
     * Sets the button style to danger
     *
     * @see https://discord.com/developers/docs/interactions/message-components#button-object-button-styles
     * @return $this
     */
    public function withDangerStyle(): self
    {
        $this->style = static::STYLE_DANGER;
        return $this;
    }
}
