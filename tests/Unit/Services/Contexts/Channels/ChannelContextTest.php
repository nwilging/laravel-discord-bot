<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Services\Contexts\Channels;

use Mockery\MockInterface;
use Nwilging\LaravelDiscordBot\Contracts\Services\Api\DiscordChannelApiServiceContract;
use Nwilging\LaravelDiscordBot\Contracts\Services\Contexts\ServiceContextFactoryContract;
use Nwilging\LaravelDiscordBot\Services\Contexts\Channels\ChannelContext;
use Nwilging\LaravelDiscordBot\Services\Contexts\Channels\Messages\MessageContext;
use Nwilging\LaravelDiscordBot\Services\Contexts\Channels\Messages\MessagesContext;
use Nwilging\LaravelDiscordBotTests\TestCase;

class ChannelContextTest extends TestCase
{
    protected MockInterface $discordChannelService;

    protected MockInterface $serviceContextFactory;

    protected string $channelId = 'test-channel-id';

    protected ChannelContext $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->discordChannelService = \Mockery::mock(DiscordChannelApiServiceContract::class);
        $this->serviceContextFactory = \Mockery::mock(ServiceContextFactoryContract::class);
        $this->service = new ChannelContext(
            $this->serviceContextFactory,
            $this->discordChannelService,
            $this->channelId
        );
    }

    public function testRead(): void
    {
        $this->discordChannelService
            ->shouldReceive('getChannel')
            ->once()
            ->with($this->channelId)
            ->andReturn(['test' => 'data']);

        $this->assertEquals(['test' => 'data'], $this->service->read());
    }

    public function testDelete(): void
    {
        $this->discordChannelService
            ->shouldReceive('deleteChannel')
            ->once()
            ->with($this->channelId);

        $this->service->delete();
    }

    public function testModify(): void
    {
        $this->discordChannelService
            ->shouldReceive('modifyChannel')
            ->once()
            ->with($this->channelId, ['test' => 'data'])
            ->andReturn(['test' => 'data']);

        $this->assertEquals(['test' => 'data'], $this->service->modify(['test' => 'data']));
    }

    public function testMessages(): void
    {
        $this->serviceContextFactory
            ->shouldReceive('make')
            ->once()
            ->with(MessagesContext::class, [
                'channelId' => $this->channelId,
            ])->andReturn(\Mockery::mock(MessagesContext::class));

        $this->assertInstanceOf(MessagesContext::class, $this->service->messages());
    }

    public function testMessage(): void
    {
        $messageId = 'test-message-id';

        $this->serviceContextFactory
            ->shouldReceive('make')
            ->once()
            ->with(MessageContext::class, [
                'channelId' => $this->channelId,
                'messageId' => $messageId,
            ])->andReturn(\Mockery::mock(MessageContext::class));

        $this->assertInstanceOf(MessageContext::class, $this->service->message($messageId));
    }
}