<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Services\Contexts\Channels;

use Mockery\MockInterface;
use Nwilging\LaravelDiscordBot\Contracts\Services\Api\DiscordGuildApiServiceContract;
use Nwilging\LaravelDiscordBot\Contracts\Services\Contexts\ServiceContextFactoryContract;
use Nwilging\LaravelDiscordBot\Services\Contexts\Channels\ChannelContext;
use Nwilging\LaravelDiscordBot\Services\Contexts\Channels\ChannelsContext;
use Nwilging\LaravelDiscordBotTests\TestCase;

class ChannelsContextTest extends TestCase
{
    protected MockInterface $serviceContextFactory;

    protected MockInterface $discordGuildService;

    protected string $guildId = 'test-guild-id';

    protected ChannelsContext $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->serviceContextFactory = \Mockery::mock(ServiceContextFactoryContract::class);
        $this->discordGuildService = \Mockery::mock(DiscordGuildApiServiceContract::class);
        $this->service = new ChannelsContext(
            $this->serviceContextFactory,
            $this->discordGuildService,
            $this->guildId
        );
    }

    public function testChannel(): void
    {
        $channelId = 'test-channel-id';

        $context = \Mockery::mock(ChannelContext::class);
        $this->serviceContextFactory
            ->shouldReceive('make')
            ->once()
            ->with(ChannelContext::class, [
                'channelId' => $channelId,
            ])->andReturn($context);

        $result = $this->service->channel($channelId);
        $this->assertSame($context, $result);
    }

    public function testRead(): void
    {
        $channels = [
            [
                'id' => 'test-channel-id',
                'name' => 'test-channel-name',
            ],
        ];

        $this->discordGuildService
            ->shouldReceive('getGuildChannels')
            ->once()
            ->with($this->guildId)
            ->andReturn($channels);

        $result = $this->service->read();
        $this->assertSame($channels, $result);
    }
}
