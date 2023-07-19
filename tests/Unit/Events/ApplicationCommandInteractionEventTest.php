<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Events;

use Nwilging\LaravelDiscordBot\Events\ApplicationCommandInteractionEvent;
use Nwilging\LaravelDiscordBot\Events\MessageComponentInteractionEvent;
use Nwilging\LaravelDiscordBotTests\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;

class ApplicationCommandInteractionEventTest extends TestCase
{
    public function testEvent()
    {
        $parameterBag = \Mockery::mock(ParameterBag::class);
        $event = new MessageComponentInteractionEvent($parameterBag);

        $this->assertSame($parameterBag, $event->getInteractionRequest());
    }

    public function testGetters()
    {
        $commandName = 'test-command-name';
        $commandId = 'test-command-id';
        $channelId = 'test-channel-id';
        $applicationId = 'test-app-id';
        $type = 42;
        $interactionId = 'test-interaction-id';
        $interactionToken = 'test-interaction-token';

        $data = [
            'name' => $commandName,
            'id' => $commandId,
            'type' => $type,
        ];

        $parameterBag = new ParameterBag([
            'application_id' => $applicationId,
            'channel_id' => $channelId,
            'id' => $interactionId,
            'token' => $interactionToken,
            'data' => $data,
        ]);

        $event = new ApplicationCommandInteractionEvent($parameterBag);

        $this->assertSame($commandName, $event->getCommandName());
        $this->assertSame($commandId, $event->getCommandId());
        $this->assertSame($channelId, $event->getChannelId());
        $this->assertSame($applicationId, $event->getApplicationId());
        $this->assertSame($type, $event->getCommandType());
        $this->assertSame($interactionId, $event->getInteractionId());
        $this->assertSame($interactionToken, $event->getInteractionToken());
    }
}
