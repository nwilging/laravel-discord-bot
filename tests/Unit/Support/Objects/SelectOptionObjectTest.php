<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Objects;

use Nwilging\LaravelDiscordBot\Support\Objects\EmojiObject;
use Nwilging\LaravelDiscordBot\Support\Objects\SelectOptionObject;
use Nwilging\LaravelDiscordBotTests\TestCase;

class SelectOptionObjectTest extends TestCase
{
    public function testObject()
    {
        $label = 'test label';
        $value = 'test value';

        $object = new SelectOptionObject($label, $value);

        $this->assertEquals([
            'label' => $label,
            'value' => $value,
        ], $object->toArray());
    }

    public function testObjectWithOptions()
    {
        $label = 'test label';
        $value = 'test value';

        $expectedEmojiArray = ['key' => 'value'];

        $emoji = \Mockery::mock(EmojiObject::class);
        $emoji->shouldReceive('toArray')->andReturn($expectedEmojiArray);

        $object = new SelectOptionObject($label, $value);

        $object->withEmoji($emoji);
        $object->withDescription('test description');
        $object->default();

        $this->assertEquals([
            'label' => $label,
            'value' => $value,
            'emoji' => $expectedEmojiArray,
            'default' => true,
            'description' => 'test description',
        ], $object->toArray());
    }
}
