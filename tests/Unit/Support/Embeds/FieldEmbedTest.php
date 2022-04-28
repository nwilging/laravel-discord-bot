<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Embeds;

use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Embeds\FieldEmbed;
use Nwilging\LaravelDiscordBotTests\TestCase;

class FieldEmbedTest extends TestCase
{
    public function testEmbed()
    {
        $name = 'test name';
        $value = 'test value';

        $embed = new FieldEmbed($name, $value);
        $this->assertEquals([
            'type' => Embed::TYPE_FIELD,
            'field' => [
                'name' => $name,
                'value' => $value,
            ],
        ], $embed->toArray());
    }

    public function testEmbedWithOptions()
    {
        $name = 'test name';
        $value = 'test value';
        $color = 12345;
        $title = 'test title';
        $description = 'test description';
        $timestamp = '12345';

        $embed = new FieldEmbed($name, $value, $title, $description, $timestamp);
        $embed->inline();
        $embed->withColor($color);

        $this->assertEquals([
            'type' => Embed::TYPE_FIELD,
            'field' => [
                'name' => $name,
                'value' => $value,
                'inline' => true,
            ],
            'title' => $title,
            'description' => $description,
            'timestamp' => $timestamp,
            'color' => $color,
        ], $embed->toArray());
    }
}
