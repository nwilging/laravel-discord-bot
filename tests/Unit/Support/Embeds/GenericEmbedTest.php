<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Embeds;

use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Embeds\GenericEmbed;
use Nwilging\LaravelDiscordBotTests\TestCase;

class GenericEmbedTest extends TestCase
{
    public function testEmbed()
    {
        $embed = new GenericEmbed('test title', 'test description');
        $this->assertEquals([
            'type' => Embed::TYPE_RICH,
            'title' => 'test title',
            'description' => 'test description',
        ], $embed->toArray());
    }

    public function testEmbedWithOptions()
    {
        $title = 'test title';
        $description = 'test description';

        $embed = new GenericEmbed($title, $description);

        $embed->withColor(42);

        $this->assertEquals([
            'type' => Embed::TYPE_RICH,
            'title' => $title,
            'description' => $description,
            'color' => 42,
        ], $embed->toArray());
    }
}
