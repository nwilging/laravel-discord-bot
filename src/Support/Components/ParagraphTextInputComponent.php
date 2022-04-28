<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Components;

use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

/**
 * Paragraph Text Input Component
 * @see https://discord.com/developers/docs/interactions/message-components#text-inputs-text-input-structure
 */
class ParagraphTextInputComponent extends GenericTextInputComponent
{
    use MergesArrays;

    public function __construct(string $label, string $customId)
    {
        parent::__construct(static::STYLE_PARAGRAPH, $label, $customId);
    }
}
