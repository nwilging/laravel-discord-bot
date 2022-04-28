<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Objects;

use Nwilging\LaravelDiscordBot\Support\Objects\EmojiObject;
use Nwilging\LaravelDiscordBotTests\TestCase;

class EmojiObjectTest extends TestCase
{
    public function testObject()
    {
        $name = 'test_emoji';
        $object = new EmojiObject($name);

        $this->assertEquals([
            'name' => $name,
        ], $object->toArray());
    }
}
