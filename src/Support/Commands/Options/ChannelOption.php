<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Commands\Options;

use Nwilging\LaravelDiscordBot\Support\Commands\CommandOption;
use Nwilging\LaravelDiscordBot\Support\Traits\ApplicationCommand\NoChoiceTransformer;
use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

class ChannelOption extends CommandOption
{
    use NoChoiceTransformer, MergesArrays;

    /**
     * @var int[]|null
     */
    protected ?array $channelTypes = null;

    /**
     * If the option is a channel type, the channels shown will be restricted to these types
     *
     * @see https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-structure
     *
     * @param array $types
     * @return $this
     */
    public function channelTypes(array $types): self
    {
        $this->channelTypes = $types;
        return $this;
    }

    public function getType(): int
    {
        return static::TYPE_CHANNEL;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'channel_types' => $this->channelTypes,
        ]);
    }
}
