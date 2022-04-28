<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Objects;

use Nwilging\LaravelDiscordBot\Support\SupportObject;
use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

/**
 * Emoji Object
 * @see https://discord.com/developers/docs/resources/emoji#emoji-object-emoji-structure
 */
class EmojiObject extends SupportObject
{
    use MergesArrays;

    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Returns a Discord-API compliant emoji object array
     *
     * @see https://discord.com/developers/docs/resources/emoji#emoji-object-emoji-structure
     * @return array
     */
    public function toArray(): array
    {
        return $this->toMergedArray([
            'name' => $this->name,
        ]);
    }
}
