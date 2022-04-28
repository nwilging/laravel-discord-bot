<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Builder;

use Nwilging\LaravelDiscordBot\Support\Builder\ComponentBuilder;
use Nwilging\LaravelDiscordBot\Support\Component;
use Nwilging\LaravelDiscordBot\Support\Components\ActionRow;
use Nwilging\LaravelDiscordBot\Support\Components\GenericButtonComponent;
use Nwilging\LaravelDiscordBot\Support\Components\GenericTextInputComponent;
use Nwilging\LaravelDiscordBot\Support\Objects\SelectOptionObject;
use Nwilging\LaravelDiscordBotTests\TestCase;

class ComponentBuilderTest extends TestCase
{
    public function testComponentBuilderBasics()
    {
        $builder = new ComponentBuilder();

        $expectedComponent1Array = ['k1' => 'v1'];
        $expectedComponent2Array = ['k2' => 'v2'];

        $component1 = \Mockery::mock(Component::class);
        $component2 = \Mockery::mock(Component::class);

        $component1->shouldReceive('toArray')->andReturn($expectedComponent1Array);
        $component2->shouldReceive('toArray')->andReturn($expectedComponent2Array);

        $builder->addComponent($component1)->addComponent($component2);

        $actionRow = $builder->getActionRow();

        $this->assertInstanceOf(ActionRow::class, $actionRow);
        $this->assertEquals([
            'type' => Component::TYPE_ACTION_ROW,
            'components' => [$expectedComponent1Array, $expectedComponent2Array],
        ], $actionRow->toArray());
    }

    public function testWithSelectMenuObject()
    {
        $builder = new ComponentBuilder();

        $label = 'test label';
        $value = 'test value';

        $option = $builder->withSelectOptionObject($label, $value);

        $this->assertInstanceOf(SelectOptionObject::class, $option);
        $this->assertEquals([
            'label' => $label,
            'value' => $value,
        ], $option->toArray());
    }

    public function testAddActionButton()
    {
        $builder = new ComponentBuilder();

        $label = 'test label';
        $customId = 'custom-id';

        $builder->addActionButton($label, $customId);
        $actionRow = $builder->getActionRow();

        $this->assertEquals([
            'type' => Component::TYPE_ACTION_ROW,
            'components' => [
                [
                    'type' => Component::TYPE_BUTTON,
                    'custom_id' => $customId,
                    'style' => GenericButtonComponent::STYLE_PRIMARY,
                    'label' => $label,
                ],
            ],
        ], $actionRow->toArray());
    }

    public function testAddLinkButton()
    {
        $builder = new ComponentBuilder();

        $label = 'test label';
        $url = 'test url';

        $builder->addLinkButton($label, $url);
        $actionRow = $builder->getActionRow();

        $this->assertEquals([
            'type' => Component::TYPE_ACTION_ROW,
            'components' => [
                [
                    'type' => Component::TYPE_BUTTON,
                    'url' => $url,
                    'style' => GenericButtonComponent::STYLE_LINK,
                    'label' => $label,
                ],
            ],
        ], $actionRow->toArray());
    }

    public function testAddSelectMenuComponent()
    {
        $builder = new ComponentBuilder();

        $customId = 'custom-id';
        $builder->addSelectMenuComponent([
            $builder->withSelectOptionObject('option1', 'value1'),
            $builder->withSelectOptionObject('option2', 'value2'),
        ], $customId);

        $actionRow = $builder->getActionRow();
        $this->assertEquals([
            'type' => Component::TYPE_ACTION_ROW,
            'components' => [
                [
                    'type' => Component::TYPE_SELECT_MENU,
                    'custom_id' => $customId,
                    'options' => [
                        [
                            'label' => 'option1',
                            'value' => 'value1',
                        ],
                        [
                            'label' => 'option2',
                            'value' => 'value2',
                        ]
                    ],
                ],
            ],
        ], $actionRow->toArray());
    }

    public function testAddShortTextInput()
    {
        $builder = new ComponentBuilder();

        $label = 'test label';
        $customId = 'custom-id';

        $builder->addShortTextInput($label, $customId);
        $actionButton = $builder->getActionRow();

        $this->assertEquals([
            'type' => Component::TYPE_ACTION_ROW,
            'components' => [
                [
                    'type' => Component::TYPE_TEXT_INPUT,
                    'custom_id' => $customId,
                    'style' => GenericTextInputComponent::STYLE_SHORT,
                    'label' => $label,
                ],
            ],
        ], $actionButton->toArray());
    }

    public function testParagraphTextInput()
    {
        $builder = new ComponentBuilder();

        $label = 'test label';
        $customId = 'custom-id';

        $builder->addParagraphTextInput($label, $customId);
        $actionButton = $builder->getActionRow();

        $this->assertEquals([
            'type' => Component::TYPE_ACTION_ROW,
            'components' => [
                [
                    'type' => Component::TYPE_TEXT_INPUT,
                    'custom_id' => $customId,
                    'style' => GenericTextInputComponent::STYLE_PARAGRAPH,
                    'label' => $label,
                ],
            ],
        ], $actionButton->toArray());
    }
}
