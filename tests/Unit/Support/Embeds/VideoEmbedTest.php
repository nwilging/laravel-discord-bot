<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Embeds;

use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Embeds\VideoEmbed;
use Nwilging\LaravelDiscordBotTests\TestCase;

class VideoEmbedTest extends TestCase
{
    public function testEmbed()
    {
        $url = 'https://example.com';
        $embed = new VideoEmbed($url);

        $this->assertEquals([
            'type' => Embed::TYPE_VIDEO,
            'video' => [
                'url' => $url,
            ],
        ], $embed->toArray());
    }

    public function testEmbedWithOptions()
    {
        $url = 'https://example.com';
        $title = 'test title';
        $description = 'test description';
        $timestamp = '12345';

        $proxyUrl = 'https://example.com/proxy';
        $height = 256;
        $width = 512;

        $embed = new VideoEmbed($url, $title, $description, $timestamp);

        $embed->withProxyUrl($proxyUrl);
        $embed->withWidth($width);
        $embed->withHeight($height);

        $this->assertEquals([
            'type' => Embed::TYPE_VIDEO,
            'video' => [
                'url' => $url,
                'proxy_url' => $proxyUrl,
                'height' => $height,
                'width' => $width,
            ],
            'title' => $title,
            'description' => $description,
            'timestamp' => $timestamp,
        ], $embed->toArray());
    }
}
