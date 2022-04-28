<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Embeds;

use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

/**
 * Image Embed
 * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-image-structure
 */
class ImageEmbed extends Embed
{
    use MergesArrays;

    protected string $url;

    protected ?string $proxyUrl = null;

    protected ?int $height = null;

    protected ?int $width = null;

    public function __construct(string $url, ?string $title = null, ?string $description = null, ?string $timestamp = null)
    {
        parent::__construct($title, $description, $timestamp);
        $this->url = $url;
    }

    /**
     * A proxied url of the image
     *
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-image-structure
     * @param string $proxyUrl
     * @return $this
     */
    public function withProxyUrl(string $proxyUrl): self
    {
        $this->proxyUrl = $proxyUrl;
        return $this;
    }

    /**
     * Image height
     *
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-image-structure
     * @param int $height
     * @return $this
     */
    public function withHeight(int $height): self
    {
        $this->height = $height;
        return $this;
    }

    /**
     * Image width
     *
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-image-structure
     * @param int $width
     * @return $this
     */
    public function withWidth(int $width): self
    {
        $this->width = $width;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_IMAGE;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'image' => [
                'url' => $this->url,
                'proxy_url' => $this->proxyUrl,
                'height' => $this->height,
                'width' => $this->width,
            ],
        ]);
    }
}
