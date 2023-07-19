<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Services\Contexts\Channels\Messages;

use Nwilging\LaravelDiscordBot\Contracts\Services\Api\DiscordChannelApiServiceContract;
use Nwilging\LaravelDiscordBot\Contracts\Services\Contexts\ServiceContextFactoryContract;
use Nwilging\LaravelDiscordBot\Services\Contexts\ServiceContext;
use Nwilging\LaravelDiscordBot\Traits\Services\Contexts\ReadAbility;

class MessagesContext extends ServiceContext
{
    use ReadAbility;

    protected DiscordChannelApiServiceContract $discordChannelService;

    protected string $channelId;

    public function __construct(
        ServiceContextFactoryContract $contextFactory,
        DiscordChannelApiServiceContract $discordChannelService,
        string $channelId
    ) {
        parent::__construct($contextFactory);

        $this->discordChannelService = $discordChannelService;
        $this->channelId = $channelId;
    }

    public function create(array $data): array
    {
        return $this->discordChannelService->createMessage($this->channelId, $data);
    }

    public function message(string $messageId): MessageContext
    {
        return $this->makeContext(MessageContext::class, [
            'channelId' => $this->channelId,
            'messageId' => $messageId,
        ]);
    }

    protected function readMethod(): \Closure
    {
        return function () {
            return $this->discordChannelService->getChannelMessages($this->channelId);
        };
    }
}
