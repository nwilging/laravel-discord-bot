<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Embeds;

use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Embeds\AuthorEmbed;
use Nwilging\LaravelDiscordBotTests\TestCase;

class AuthorEmbedTest extends TestCase
{
    public function testEmbed()
    {
        $name = 'test name';
        $embed = new AuthorEmbed($name);

        $this->assertEquals([
            'type' => Embed::TYPE_AUTHOR,
            'author' => [
                'name' => $name,
            ],
        ], $embed->toArray());
    }

    public function testEmbedWithOptions()
    {
        $name = 'test name';
        $title = 'test title';
        $description = 'test description';
        $timestamp = '12345';

        $url = 'https://example.com';
        $iconUrl = 'https://example.com/icon';
        $proxyIconUrl = 'https://example.com/proxy';

        $embed = new AuthorEmbed($name, $title, $description, $timestamp);

        $embed->withUrl($url);
        $embed->withIconUrl($iconUrl);
        $embed->withProxyIconUrl($proxyIconUrl);

        $this->assertEquals([
            'type' => Embed::TYPE_AUTHOR,
            'author' => [
                'name' => $name,
                'url' => $url,
                'icon_url' => $iconUrl,
                'proxy_icon_url' => $proxyIconUrl,
            ],
            'title' => $title,
            'description' => $description,
            'timestamp' => $timestamp,
        ], $embed->toArray());
    }
}
