<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Components;

use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

/**
 * Link Button Component
 * @see https://discord.com/developers/docs/interactions/message-components#buttons
 */
class LinkButtonComponent extends GenericButtonComponent
{
    use MergesArrays;

    protected string $url;

    public function __construct(string $label, string $url)
    {
        parent::__construct(static::STYLE_LINK, $label);
        $this->url = $url;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'url' => $this->url,
        ]);
    }
}
