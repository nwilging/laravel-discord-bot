<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Channels;

use Illuminate\Notifications\Notifiable;
use Mockery\MockInterface;
use Nwilging\LaravelDiscordBot\Channels\DiscordNotificationChannel;
use Nwilging\LaravelDiscordBot\Contracts\Notifications\DiscordNotificationContract;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordApiServiceContract;
use Nwilging\LaravelDiscordBot\Support\Component;
use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBotTests\TestCase;

class DiscordNotificationChannelTest extends TestCase
{
    protected MockInterface $discordApiService;

    protected DiscordNotificationChannel $channel;

    public function setUp(): void
    {
        parent::setUp();

        $this->discordApiService = \Mockery::mock(DiscordApiServiceContract::class);
        $this->channel = new DiscordNotificationChannel($this->discordApiService);
    }

    public function testSendPlainText()
    {
        $notifiable = \Mockery::mock(Notifiable::class);
        $notification = \Mockery::mock(DiscordNotificationContract::class);

        $discordNotificationArray = [
            'contentType' => 'plain',
            'channelId' => '12345',
            'message' => 'test message',
        ];

        $expectedResponse = [
            'key' => 'value',
        ];

        $notification->shouldReceive('toDiscord')
            ->once()
            ->with($notifiable)
            ->andReturn($discordNotificationArray);

        $this->discordApiService->shouldReceive('sendTextMessage')
            ->once()
            ->with('12345', 'test message', [])
            ->andReturn($expectedResponse);

        $result = $this->channel->send($notifiable, $notification);
        $this->assertEquals($expectedResponse, $result);
    }

    public function testSendRichText()
    {
        $notifiable = \Mockery::mock(Notifiable::class);
        $notification = \Mockery::mock(DiscordNotificationContract::class);

        $embed1 = \Mockery::mock(Embed::class);
        $embed2 = \Mockery::mock(Embed::class);

        $component1 = \Mockery::mock(Component::class);
        $component2 = \Mockery::mock(Component::class);

        $discordNotificationArray = [
            'contentType' => 'rich',
            'channelId' => '12345',
            'embeds' => [$embed1, $embed2],
            'components' => [$component1, $component2],
        ];

        $expectedResponse = [
            'key' => 'value',
        ];

        $notification->shouldReceive('toDiscord')
            ->once()
            ->with($notifiable)
            ->andReturn($discordNotificationArray);

        $this->discordApiService->shouldReceive('sendRichTextMessage')
            ->once()
            ->with('12345', [$embed1, $embed2], [$component1, $component2], [])
            ->andReturn($expectedResponse);

        $result = $this->channel->send($notifiable, $notification);
        $this->assertEquals($expectedResponse, $result);
    }

    public function testSendWithInvalidContentTypeThrowsException()
    {
        $notifiable = \Mockery::mock(Notifiable::class);
        $notification = \Mockery::mock(DiscordNotificationContract::class);

        $discordNotificationArray = [
            'contentType' => 'invalid',
        ];

        $notification->shouldReceive('toDiscord')
            ->once()
            ->with($notifiable)
            ->andReturn($discordNotificationArray);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('invalid is not a valid contentType');

        $this->channel->send($notifiable, $notification);
    }
}
