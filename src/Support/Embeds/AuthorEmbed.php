<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Embeds;

use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

/**
 * Author Embed
 * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-author-structure
 */
class AuthorEmbed extends Embed
{
    use MergesArrays;

    protected string $name;

    protected ?string $url = null;

    protected ?string $iconUrl = null;

    protected ?string $proxyIconUrl = null;

    public function __construct(string $name, ?string $title = null, ?string $description = null, ?string $timestamp = null)
    {
        parent::__construct($title, $description, $timestamp);
        $this->name = $name;
    }

    /**
     * URL of author
     *
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-author-structure
     * @param string $url
     * @return $this
     */
    public function withUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * URL of author icon (only supports http(s) and attachments)
     *
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-author-structure
     * @param string $iconUrl
     * @return $this
     */
    public function withIconUrl(string $iconUrl): self
    {
        $this->iconUrl = $iconUrl;
        return $this;
    }

    /**
     * A proxied url of author icon
     *
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-author-structure
     * @param string $proxyIconUrl
     * @return $this
     */
    public function withProxyIconUrl(string $proxyIconUrl): self
    {
        $this->proxyIconUrl = $proxyIconUrl;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_AUTHOR;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'author' => [
                'name' => $this->name,
                'url' => $this->url,
                'icon_url' => $this->iconUrl,
                'proxy_icon_url' => $this->proxyIconUrl,
            ],
        ]);
    }
}
