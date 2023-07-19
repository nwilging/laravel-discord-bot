<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Services\Contexts\Channels\Messages;

use Nwilging\LaravelDiscordBot\Contracts\Services\Api\DiscordChannelApiServiceContract;
use Nwilging\LaravelDiscordBot\Contracts\Services\Contexts\ServiceContextFactoryContract;
use Nwilging\LaravelDiscordBot\Services\Contexts\ServiceContext;
use Nwilging\LaravelDiscordBot\Traits\Services\Contexts\ReadAbility;

class MessageContext extends ServiceContext
{
    use ReadAbility;

    protected DiscordChannelApiServiceContract $discordChannelService;

    protected string $channelId;

    protected string $messageId;

    public function __construct(
        ServiceContextFactoryContract $contextFactory,
        DiscordChannelApiServiceContract $discordChannelService,
        string $channelId,
        string $messageId
    ) {
        parent::__construct($contextFactory);

        $this->discordChannelService = $discordChannelService;
        $this->channelId = $channelId;
        $this->messageId = $messageId;
    }

    public function crosspost(): array
    {
        return $this->discordChannelService->crosspostMessage($this->channelId, $this->messageId);
    }

    protected function readMethod(): \Closure
    {
        return function () {
            return $this->discordChannelService->getChannelMessage($this->channelId, $this->messageId);
        };
    }
}
