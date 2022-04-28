<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Embeds;

use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

/**
 * Provider Embed
 * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-provider-structure
 */
class ProviderEmbed extends Embed
{
    use MergesArrays;

    protected ?string $name = null;

    protected ?string $url = null;

    public function __construct(?string $title = null, ?string $description = null, ?string $timestamp = null)
    {
        parent::__construct($title, $description, $timestamp);
    }

    /**
     * Name of provider
     *
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-provider-structure
     * @param string $name
     * @return $this
     */
    public function withName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * URL of provider
     *
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-provider-structure
     * @param string $url
     * @return $this
     */
    public function withUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_PROVIDER;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'provider' => [
                'name' => $this->name,
                'url' => $this->url,
            ],
        ]);
    }
}
