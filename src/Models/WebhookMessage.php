<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Models;

use Nwilging\LaravelDiscordBot\Support\Component;
use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Traits\FiltersRecursive;

class WebhookMessage
{
    use FiltersRecursive;

    public ?bool $wait = null;

    public ?string $threadId = null;

    public ?string $content = null;

    public ?string $username = null;

    public ?string $avatarUrl = null;

    public ?bool $tts = null;

    /**
     * @var Embed[]
     */
    public array $embeds = [];

    /**
     * @var Component[]
     */
    public array $components = [];

    public ?int $flags = null;

    public ?string $threadName = null;

    public function toArray(): array
    {
        return $this->arrayFilterRecursive([
            'content' => $this->content,
            'username' => $this->username,
            'avatar_url' => $this->avatarUrl,
            'tts' => $this->tts,
            'embeds' => array_map(function (Embed $embed) {
                return $embed->toArray();
            }, $this->embeds),
            'components' => array_map(function (Component $component) {
                return $component->toArray();
            }, $this->components),
            'flags' => $this->flags,
            'thread_id' => $this->threadId,
            'thread_name' => $this->threadName,
        ]);
    }
}
