<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Interactions\Handlers;

use Illuminate\Http\Request;
use Nwilging\LaravelDiscordBot\Support\Interactions\Handlers\PingHandler;
use Nwilging\LaravelDiscordBot\Support\Interactions\InteractionHandler;
use Nwilging\LaravelDiscordBotTests\TestCase;

class PingHandlerTest extends TestCase
{
    public function testHandler()
    {
        $handler = new PingHandler();
        $result = $handler->handle(\Mockery::mock(Request::class));

        $this->assertSame(200, $result->getStatus());
        $this->assertEquals([
            'type' => InteractionHandler::RESPONSE_TYPE_PONG,
        ], $result->toArray());
    }
}
