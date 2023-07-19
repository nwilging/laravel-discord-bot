<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Services\Contexts\Channels;

use Nwilging\LaravelDiscordBot\Contracts\Services\Api\DiscordChannelApiServiceContract;
use Nwilging\LaravelDiscordBot\Contracts\Services\Contexts\ServiceContextFactoryContract;
use Nwilging\LaravelDiscordBot\Services\Contexts\Channels\Messages\MessageContext;
use Nwilging\LaravelDiscordBot\Services\Contexts\Channels\Messages\MessagesContext;
use Nwilging\LaravelDiscordBot\Services\Contexts\ServiceContext;
use Nwilging\LaravelDiscordBot\Traits\Services\Contexts\ReadAbility;

class ChannelContext extends ServiceContext
{
    use ReadAbility;

    protected DiscordChannelApiServiceContract $discordChannelService;

    protected string $channelId;

    public function __construct(
        ServiceContextFactoryContract $contextFactory,
        DiscordChannelApiServiceContract $discordChannelService,
        string $channelId
    )
    {
        parent::__construct($contextFactory);

        $this->discordChannelService = $discordChannelService;
        $this->channelId = $channelId;
    }

    protected function readMethod(): \Closure
    {
        return function (): array {
            return $this->discordChannelService->getChannel($this->channelId);
        };
    }

    public function delete(): void
    {
        $this->discordChannelService->deleteChannel($this->channelId);
    }

    public function modify(array $data): array
    {
        return $this->discordChannelService->modifyChannel($this->channelId, $data);
    }

    public function messages(): MessagesContext
    {
        return $this->makeContext(MessagesContext::class, [
            'channelId' => $this->channelId,
        ]);
    }

    public function message(string $messageId): MessageContext
    {
        return $this->makeContext(MessageContext::class, [
            'channelId' => $this->channelId,
            'messageId' => $messageId,
        ]);
    }
}
