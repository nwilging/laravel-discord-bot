<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Components;

use Nwilging\LaravelDiscordBot\Support\Component;
use Nwilging\LaravelDiscordBot\Support\Components\SelectMenuComponent;
use Nwilging\LaravelDiscordBot\Support\Objects\SelectOptionObject;
use Nwilging\LaravelDiscordBotTests\TestCase;

class SelectMenuComponentTest extends TestCase
{
    public function testComponent()
    {
        $customId = 'custom-id';

        $expectedOption1Array = ['k1' => 'v1'];
        $expectedOption2Array = ['k2' => 'v2'];

        $option1 = \Mockery::mock(SelectOptionObject::class);
        $option2 = \Mockery::mock(SelectOptionObject::class);

        $option1->shouldReceive('toArray')->andReturn($expectedOption1Array);
        $option2->shouldReceive('toArray')->andReturn($expectedOption2Array);

        $component = new SelectMenuComponent($customId, [$option1, $option2]);

        $this->assertEquals([
            'type' => Component::TYPE_SELECT_MENU,
            'custom_id' => $customId,
            'options' => [$expectedOption1Array, $expectedOption2Array],
        ], $component->toArray());
    }

    public function testComponentWithOptions()
    {
        $customId = 'custom-id';

        $expectedOption1Array = ['k1' => 'v1'];
        $expectedOption2Array = ['k2' => 'v2'];

        $option1 = \Mockery::mock(SelectOptionObject::class);
        $option2 = \Mockery::mock(SelectOptionObject::class);

        $option1->shouldReceive('toArray')->andReturn($expectedOption1Array);
        $option2->shouldReceive('toArray')->andReturn($expectedOption2Array);

        $component = new SelectMenuComponent($customId, [$option1, $option2]);
        $component->withPlaceholder('test placeholder');
        $component->withMinValues(5);
        $component->withMaxValues(10);
        $component->disabled();

        $this->assertEquals([
            'type' => Component::TYPE_SELECT_MENU,
            'custom_id' => $customId,
            'options' => [$expectedOption1Array, $expectedOption2Array],
            'placeholder' => 'test placeholder',
            'min_values' => 5,
            'max_values' => 10,
            'disabled' => true,
        ], $component->toArray());
    }
}
