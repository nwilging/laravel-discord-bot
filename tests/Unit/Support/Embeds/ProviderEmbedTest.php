<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Embeds;

use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Embeds\ProviderEmbed;
use Nwilging\LaravelDiscordBotTests\TestCase;

class ProviderEmbedTest extends TestCase
{
    public function testEmbed()
    {
        $embed = new ProviderEmbed();
        $this->assertEquals([
            'type' => Embed::TYPE_PROVIDER,
        ], $embed->toArray());
    }

    public function testEmbedWithOptions()
    {
        $title = 'test title';
        $description = 'test description';
        $timestamp = '12345';
        $url = 'https://example.com';
        $name = 'test name';

        $embed = new ProviderEmbed($title, $description, $timestamp);

        $embed->withName($name);
        $embed->withUrl($url);

        $this->assertEquals([
            'type' => Embed::TYPE_PROVIDER,
            'provider' => [
                'url' => $url,
                'name' => $name,
            ],
            'title' => $title,
            'description' => $description,
            'timestamp' => $timestamp,
        ], $embed->toArray());
    }
}
