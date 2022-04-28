<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Embeds;

/**
 * Thumbnail Embed
 * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-thumbnail-structure
 */
class ThumbnailEmbed extends ImageEmbed
{
    public function getType(): string
    {
        return static::TYPE_THUMBNAIL;
    }
}
