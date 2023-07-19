<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Services\Contexts\Channels;

use Nwilging\LaravelDiscordBot\Contracts\Services\Api\DiscordGuildApiServiceContract;
use Nwilging\LaravelDiscordBot\Contracts\Services\Contexts\ServiceContextFactoryContract;
use Nwilging\LaravelDiscordBot\Services\Contexts\ServiceContext;
use Nwilging\LaravelDiscordBot\Traits\Services\Contexts\ReadAbility;

class ChannelsContext extends ServiceContext
{
    use ReadAbility;

    protected DiscordGuildApiServiceContract $discordGuildService;

    protected string $guildId;

    public function __construct(
        ServiceContextFactoryContract $contextFactory,
        DiscordGuildApiServiceContract $discordGuildService,
        string $guildId
    ) {
        parent::__construct($contextFactory);

        $this->discordGuildService = $discordGuildService;
        $this->guildId = $guildId;
    }

    public function channel(string $channelId): ChannelContext
    {
        return $this->makeContext(ChannelContext::class, [
            'channelId' => $channelId,
        ]);
    }

    protected function readMethod(): \Closure
    {
        return function () {
            return $this->discordGuildService->getGuildChannels($this->guildId);
        };
    }
}
