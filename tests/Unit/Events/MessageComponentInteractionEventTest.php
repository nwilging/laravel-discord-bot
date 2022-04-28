<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Events;

use Nwilging\LaravelDiscordBot\Events\MessageComponentInteractionEvent;
use Nwilging\LaravelDiscordBotTests\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;

class MessageComponentInteractionEventTest extends TestCase
{
    public function testEvent()
    {
        $parameterBag = \Mockery::mock(ParameterBag::class);
        $event = new MessageComponentInteractionEvent($parameterBag);

        $this->assertSame($parameterBag, $event->getInteractionRequest());
    }
}
