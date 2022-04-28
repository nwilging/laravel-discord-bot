<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Components;

use Nwilging\LaravelDiscordBot\Support\Component;
use Nwilging\LaravelDiscordBot\Support\Components\GenericButtonComponent;
use Nwilging\LaravelDiscordBot\Support\Components\LinkButtonComponent;
use Nwilging\LaravelDiscordBot\Support\Objects\EmojiObject;
use Nwilging\LaravelDiscordBotTests\TestCase;

class LinkButtonComponentTest extends TestCase
{
    public function testComponent()
    {
        $label = 'test label';
        $url = 'https://example.com';

        $component = new LinkButtonComponent($label, $url);

        $this->assertEquals([
            'type' => Component::TYPE_BUTTON,
            'style' => GenericButtonComponent::STYLE_LINK,
            'label' => $label,
            'url' => $url,
        ], $component->toArray());
    }

    public function testComponentWithOptions()
    {
        $label = 'test label';
        $url = 'https://example.com';

        $expectedEmojiArray = ['key' => 'value'];

        $emoji = \Mockery::mock(EmojiObject::class);
        $emoji->shouldReceive('toArray')->andReturn($expectedEmojiArray);

        $component = new LinkButtonComponent($label, $url);
        $component->withEmoji($emoji);
        $component->disabled();

        $this->assertEquals([
            'type' => Component::TYPE_BUTTON,
            'style' => GenericButtonComponent::STYLE_LINK,
            'label' => $label,
            'disabled' => true,
            'url' => $url,
            'emoji' => $expectedEmojiArray,
        ], $component->toArray());
    }
}
