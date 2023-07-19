<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Services\Contexts\Channels\Messages;

use Mockery\MockInterface;
use Nwilging\LaravelDiscordBot\Contracts\Services\Api\DiscordChannelApiServiceContract;
use Nwilging\LaravelDiscordBot\Contracts\Services\Contexts\ServiceContextFactoryContract;
use Nwilging\LaravelDiscordBot\Services\Contexts\Channels\Messages\MessageContext;
use Nwilging\LaravelDiscordBot\Services\Contexts\Channels\Messages\MessagesContext;
use Nwilging\LaravelDiscordBotTests\TestCase;

class MessagesContextTest extends TestCase
{
    protected MockInterface $discordChannelService;

    protected MockInterface $serviceContextFactory;

    protected string $channelId = 'test-channel-id';

    protected MessagesContext $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->discordChannelService = \Mockery::mock(DiscordChannelApiServiceContract::class);
        $this->serviceContextFactory = \Mockery::mock(ServiceContextFactoryContract::class);
        $this->service = new MessagesContext(
            $this->serviceContextFactory,
            $this->discordChannelService,
            $this->channelId
        );
    }

    public function testCreate(): void
    {
        $this->discordChannelService
            ->shouldReceive('createMessage')
            ->once()
            ->with($this->channelId, ['test' => 'data'])
            ->andReturn(['test' => 'data']);

        $this->assertEquals(['test' => 'data'], $this->service->create(['test' => 'data']));
    }

    public function testMessage(): void
    {
        $this->serviceContextFactory
            ->shouldReceive('make')
            ->once()
            ->with(
                MessageContext::class,
                [
                    'channelId' => $this->channelId,
                    'messageId' => 'test-message-id',
                ]
            )
            ->andReturn(\Mockery::mock(MessageContext::class));

        $this->assertInstanceOf(
            MessageContext::class,
            $this->service->message('test-message-id')
        );
    }

    public function testRead(): void
    {
        $this->discordChannelService
            ->shouldReceive('getChannelMessages')
            ->once()
            ->with($this->channelId)
            ->andReturn(['test' => 'data']);

        $this->assertEquals(['test' => 'data'], $this->service->read());
    }

//    public function testDelete(): void
//    {
//        $this->discordChannelService
//            ->shouldReceive('deleteMessages')
//            ->once()
//            ->with($this->channelId, ['test' => 'data']);
//
//        $this->service->delete(['test' => 'data']);
//    }

//    public function testModify(): void
//    {
//        $this->discordChannelService
//            ->shouldReceive('modifyChannel')
//            ->once()
//            ->with($this->channelId, ['test' => 'data']);
//
//        $this->service->modify(['test' => 'data']);
//    }
}
