<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Components;

use Nwilging\LaravelDiscordBot\Support\Component;
use Nwilging\LaravelDiscordBot\Support\Components\ActionRow;
use Nwilging\LaravelDiscordBotTests\TestCase;

class ActionRowTest extends TestCase
{
    public function testComponent()
    {
        $component = new ActionRow([]);
        $this->assertEquals([
            'type' => Component::TYPE_ACTION_ROW,
        ], $component->toArray());
    }

    public function testComponentWithComponents()
    {
        $expectedComponent1Array = ['k1' => 'v1'];
        $expectedComponent2Array = ['k2' => 'v2'];

        $component1 = \Mockery::mock(Component::class);
        $component2 = \Mockery::mock(Component::class);

        $component1->shouldReceive('toArray')->andReturn($expectedComponent1Array);
        $component2->shouldReceive('toArray')->andReturn($expectedComponent2Array);

        $component = new ActionRow([$component1]);
        $component->addComponent($component2);

        $this->assertEquals([
            'type' => Component::TYPE_ACTION_ROW,
            'components' => [$expectedComponent1Array, $expectedComponent2Array],
        ], $component->toArray());
    }
}
