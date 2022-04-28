<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Embeds;

use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

/**
 * Footer Embed
 * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-footer-structure
 */
class FooterEmbed extends Embed
{
    use MergesArrays;

    protected string $text;

    protected ?string $iconUrl = null;

    protected ?string $proxyIconUrl = null;

    public function __construct(string $text, ?string $title = null, ?string $description = null, ?string $timestamp = null)
    {
        parent::__construct($title, $description, $timestamp);
        $this->text = $text;
    }

    /**
     * URL of footer icon (only supports http(s) and attachments)
     *
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-footer-structure
     * @param string $iconUrl
     * @return $this
     */
    public function withIconUrl(string $iconUrl): self
    {
        $this->iconUrl = $iconUrl;
        return $this;
    }

    /**
     * A proxied url of footer icon
     *
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-footer-structure
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
        return static::TYPE_FOOTER;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'footer' => [
                'text' => $this->text,
                'icon_url' => $this->iconUrl,
                'proxy_icon_url' => $this->proxyIconUrl,
            ],
        ]);
    }
}
