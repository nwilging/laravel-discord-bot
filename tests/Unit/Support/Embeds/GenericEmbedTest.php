<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Embeds;

use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Embeds\AuthorEmbed;
use Nwilging\LaravelDiscordBot\Support\Embeds\FieldEmbed;
use Nwilging\LaravelDiscordBot\Support\Embeds\FooterEmbed;
use Nwilging\LaravelDiscordBot\Support\Embeds\GenericEmbed;
use Nwilging\LaravelDiscordBot\Support\Embeds\ImageEmbed;
use Nwilging\LaravelDiscordBot\Support\Embeds\ProviderEmbed;
use Nwilging\LaravelDiscordBot\Support\Embeds\ThumbnailEmbed;
use Nwilging\LaravelDiscordBot\Support\Embeds\VideoEmbed;
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

    public function testEmbedWithAllOptions()
    {
        $title = 'test title';
        $description = 'test description';

        $footer = new FooterEmbed('test footer');
        $author = new AuthorEmbed('test author');
        $provider = new ProviderEmbed('test provider');
        $image = new ImageEmbed('test image');
        $thumbnail = new ThumbnailEmbed('test thumbnail');
        $video = new VideoEmbed('test video');

        $embed = new GenericEmbed($title, $description);

        $embed->withColor(42);

        $embed->withFooter($footer);
        $embed->withAuthor($author);
        $embed->withProvider($provider);
        $embed->withImage($image);
        $embed->withThumbnail($thumbnail);
        $embed->withVideo($video);

        $field1 = new FieldEmbed('test field 1', 'test field 1 value');
        $field2 = new FieldEmbed('test field 2', 'test field 2 value');

        $embed->addField($field1)
            ->addField($field2);

        $this->assertEquals([
            'type' => Embed::TYPE_RICH,
            'title' => $title,
            'description' => $description,
            'color' => 42,
            'footer' => $footer->toArray(),
            'author' => $author->toArray(),
            'provider' => $provider->toArray(),
            'image' => $image->toArray(),
            'thumbnail' => $thumbnail->toArray(),
            'video' => $video->toArray(),
            'fields' => [
                $field1->toArray(),
                $field2->toArray(),
            ],
        ], $embed->toArray());
    }
}
