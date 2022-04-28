<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Traits;

use Nwilging\LaravelDiscordBot\Support\Objects\EmojiObject;

trait HasEmojiObject
{
    protected ?EmojiObject $emoji = null;

    public function withEmoji(EmojiObject $emoji): self
    {
        $this->emoji = $emoji;
        return $this;
    }

    protected function mergeEmojiObject(array $mergeWith): array
    {
        return array_merge($mergeWith, [
            'emoji' => ($this->emoji) ? $this->emoji->toArray() : null,
        ]);
    }
}
