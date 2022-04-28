<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support;

use Illuminate\Contracts\Support\Arrayable;
use Nwilging\LaravelDiscordBot\Support\Traits\FiltersRecursive;

/**
 * Abstract Embed Object
 * @see https://discord.com/developers/docs/resources/channel#embed-object
 */
abstract class Embed implements Arrayable
{
    use FiltersRecursive;

    public const TYPE_RICH = 'rich';
    public const TYPE_IMAGE = 'image';
    public const TYPE_VIDEO = 'video';
    public const TYPE_GIFV = 'gifv';
    public const TYPE_ARTICLE = 'article';
    public const TYPE_LINK = 'link';
    public const TYPE_FOOTER = 'footer';
    public const TYPE_THUMBNAIL = 'thumbnail';
    public const TYPE_PROVIDER = 'provider';
    public const TYPE_AUTHOR = 'author';
    public const TYPE_FIELD = 'field';

    protected ?string $title = null;

    protected ?string $description = null;

    protected ?string $timestamp = null;

    protected ?int $color = null;

    protected function __construct(?string $title = null, ?string $description = null, ?string $timestamp = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->timestamp = $timestamp;
    }

    /**
     * The color code of the embed
     *
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-structure
     *
     * @param int $colorCode
     * @return $this
     */
    public function withColor(int $colorCode): self
    {
        $this->color = $colorCode;
        return $this;
    }

    public abstract function getType(): string;

    /**
     * Returns a Discord-API compliant embed array
     *
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-structure
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->arrayFilterRecursive([
            'type' => $this->getType(),
            'title' => $this->title,
            'description' => $this->description,
            'timestamp' => $this->timestamp,
            'color' => $this->color,
        ]);
    }
}
