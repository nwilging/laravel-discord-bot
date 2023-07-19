<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Services\Contexts\Channels\Messages;

use Mockery\MockInterface;
use Nwilging\LaravelDiscordBot\Contracts\Services\Api\DiscordChannelApiServiceContract;
use Nwilging\LaravelDiscordBot\Contracts\Services\Contexts\ServiceContextFactoryContract;
use Nwilging\LaravelDiscordBot\Services\Contexts\Channels\Messages\MessageContext;
use Nwilging\LaravelDiscordBotTests\TestCase;

class MessageContextTest extends TestCase
{
    protected MockInterface $discordChannelService;

    protected MockInterface $serviceContextFactory;

    protected string $channelId = 'test-channel-id';

    protected string $messageId = 'test-message-id';

    protected MessageContext $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->discordChannelService = \Mockery::mock(DiscordChannelApiServiceContract::class);
        $this->serviceContextFactory = \Mockery::mock(ServiceContextFactoryContract::class);
        $this->service = new MessageContext(
            $this->serviceContextFactory,
            $this->discordChannelService,
            $this->channelId,
            $this->messageId
        );
    }

    public function testRead(): void
    {
        $this->discordChannelService
            ->shouldReceive('getChannelMessage')
            ->once()
            ->with($this->channelId, $this->messageId)
            ->andReturn(['test' => 'data']);

        $this->assertEquals(['test' => 'data'], $this->service->read());
    }

    public function testCrosspost(): void
    {
        $this->discordChannelService
            ->shouldReceive('crosspostMessage')
            ->once()
            ->with($this->channelId, $this->messageId)
            ->andReturn(['test' => 'data']);

        $this->assertEquals(['test' => 'data'], $this->service->crosspost());
    }
}
