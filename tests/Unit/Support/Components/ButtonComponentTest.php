<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Components;

use Nwilging\LaravelDiscordBot\Support\Component;
use Nwilging\LaravelDiscordBot\Support\Components\ButtonComponent;
use Nwilging\LaravelDiscordBot\Support\Components\GenericButtonComponent;
use Nwilging\LaravelDiscordBot\Support\Objects\EmojiObject;
use Nwilging\LaravelDiscordBotTests\TestCase;

class ButtonComponentTest extends TestCase
{
    public function testComponent()
    {
        $label = 'test label';
        $customId = 'custom-id';

        $component = new ButtonComponent($label, $customId);

        $this->assertEquals([
            'type' => Component::TYPE_BUTTON,
            'style' => GenericButtonComponent::STYLE_PRIMARY,
            'label' => $label,
            'custom_id' => $customId,
        ], $component->toArray());
    }

    public function testComponentWithOptions()
    {
        $label = 'test label';
        $customId = 'custom-id';

        $expectedEmojiArray = ['key' => 'value'];

        $emoji = \Mockery::mock(EmojiObject::class);
        $emoji->shouldReceive('toArray')->andReturn($expectedEmojiArray);

        $component = new ButtonComponent($label, $customId);
        $component->withEmoji($emoji);
        $component->disabled();

        $this->assertEquals([
            'type' => Component::TYPE_BUTTON,
            'style' => GenericButtonComponent::STYLE_PRIMARY,
            'label' => $label,
            'custom_id' => $customId,
            'disabled' => true,
            'emoji' => $expectedEmojiArray,
        ], $component->toArray());
    }

    /**
     * @dataProvider withStyleDataProvider
     */
    public function testComponentWithStyle(int $expectedStyle)
    {
        $label = 'test label';
        $customId = 'custom-id';

        $component = new ButtonComponent($label, $customId);

        switch ($expectedStyle) {
            case GenericButtonComponent::STYLE_PRIMARY:
                $component->withPrimaryStyle();
                break;
            case GenericButtonComponent::STYLE_SECONDARY:
                $component->withSecondaryStyle();
                break;
            case GenericButtonComponent::STYLE_SUCCESS:
                $component->withSuccessStyle();
                break;
            case GenericButtonComponent::STYLE_DANGER:
                $component->withDangerStyle();
                break;
        }

        $this->assertEquals([
            'type' => Component::TYPE_BUTTON,
            'style' => $expectedStyle,
            'label' => $label,
            'custom_id' => $customId,
        ], $component->toArray());
    }

    public function withStyleDataProvider(): array
    {
        return [
            [GenericButtonComponent::STYLE_PRIMARY],
            [GenericButtonComponent::STYLE_SECONDARY],
            [GenericButtonComponent::STYLE_SUCCESS],
            [GenericButtonComponent::STYLE_DANGER],
        ];
    }
}
