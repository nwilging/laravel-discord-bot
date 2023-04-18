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

    protected ?FooterEmbed $footer = null;

    protected ?ImageEmbed $image = null;

    protected ?ThumbnailEmbed $thumbnail = null;

    protected ?VideoEmbed $video = null;

    protected ?ProviderEmbed $provider = null;

    protected ?AuthorEmbed $author = null;

    /**
     * @var FieldEmbed[]
     */
    protected array $fields = [];

    public function __construct(?string $title = null, ?string $description = null, ?string $timestamp = null)
    {
        parent::__construct($title, $description, $timestamp);
    }

    public function withAuthor(AuthorEmbed $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function withFooter(FooterEmbed $footer): self
    {
        $this->footer = $footer;
        return $this;
    }

    public function withImage(ImageEmbed $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function withThumbnail(ThumbnailEmbed $thumbnail): self
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    public function withVideo(VideoEmbed $video): self
    {
        $this->video = $video;
        return $this;
    }

    public function withProvider(ProviderEmbed $provider): self
    {
        $this->provider = $provider;
        return $this;
    }

    public function addField(FieldEmbed $field): self
    {
        $this->fields[] = $field;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_RICH;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'footer' => $this->footer?->toArray(),
            'image' => $this->image?->toArray(),
            'thumbnail' => $this->thumbnail?->toArray(),
            'video' => $this->video?->toArray(),
            'provider' => $this->provider?->toArray(),
            'author' => $this->author?->toArray(),
            'fields' => array_map(function (FieldEmbed $field): array {
                return $field->toArray();
            }, $this->fields),
        ]);
    }
}
