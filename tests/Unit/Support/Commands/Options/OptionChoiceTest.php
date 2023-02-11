<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Commands\Options;

use Nwilging\LaravelDiscordBot\Support\Commands\Options\OptionChoice;
use Nwilging\LaravelDiscordBotTests\TestCase;

class OptionChoiceTest extends TestCase
{
    public function testOptionChoice()
    {
        $choice = new OptionChoice('test-name', 'test-value');

        $choice->nameLocalizations(['l1']);

        $this->assertEquals([
            'name' => 'test-name',
            'value' => 'test-value',
            'name_localizations' => ['l1'],
        ], $choice->toArray());
    }
}
