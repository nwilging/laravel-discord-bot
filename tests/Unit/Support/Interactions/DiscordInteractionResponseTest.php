<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Interactions;

use Nwilging\LaravelDiscordBot\Support\Interactions\DiscordInteractionResponse;
use Nwilging\LaravelDiscordBotTests\TestCase;

class DiscordInteractionResponseTest extends TestCase
{
    public function testClass()
    {
        $code = 201;
        $data = ['key' => 'value'];
        $type = 12;

        $response = new DiscordInteractionResponse($type, $data, $code);

        $this->assertSame($code, $response->getStatus());
        $this->assertEquals([
            'type' => $type,
            'data' => $data,
        ], $response->toArray());
    }
}
