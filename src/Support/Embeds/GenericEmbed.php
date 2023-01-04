<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Embeds;

use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

/**
 * Generic Embed - Represents the generic "rich" embed type
 * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-structure
 */
class GenericEmbed extends Embed
{
    use MergesArrays;

    public function __construct(string $title, string $description)
    {
        parent::__construct($title, $description);
    }

    public function getType(): string
    {
        return static::TYPE_RICH;
    }
}
