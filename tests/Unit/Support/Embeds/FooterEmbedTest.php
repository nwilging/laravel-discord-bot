<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Embeds;

use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Embeds\FooterEmbed;
use Nwilging\LaravelDiscordBotTests\TestCase;

class FooterEmbedTest extends TestCase
{
    public function testEmbed()
    {
        $text = 'test text';
        $embed = new FooterEmbed($text);

        $this->assertEquals([
            'type' => Embed::TYPE_FOOTER,
            'footer' => [
                'text' => $text,
            ],
        ], $embed->toArray());
    }

    public function testEmbedWithOptions()
    {
        $text = 'test text';
        $title = 'test title';
        $description = 'test description';
        $timestamp = '12345';

        $iconUrl = 'https://example.com/proxy';
        $proxyIconUrl = 'https://example.com/proxy';

        $embed = new FooterEmbed($text, $title, $description, $timestamp);

        $embed->withIconUrl($iconUrl);
        $embed->withProxyIconUrl($proxyIconUrl);
        $embed->withColor(12345);

        $this->assertEquals([
            'type' => Embed::TYPE_FOOTER,
            'footer' => [
                'text' => $text,
                'icon_url' => $iconUrl,
                'proxy_icon_url' => $proxyIconUrl,
            ],
            'title' => $title,
            'description' => $description,
            'timestamp' => $timestamp,
            'color' => 12345,
        ], $embed->toArray());
    }
}
