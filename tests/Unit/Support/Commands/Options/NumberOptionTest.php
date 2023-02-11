<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Commands\Options;

use Nwilging\LaravelDiscordBot\Support\Commands\CommandOption;
use Nwilging\LaravelDiscordBot\Support\Commands\Options\IntegerOption;
use Nwilging\LaravelDiscordBot\Support\Commands\Options\NumberOption;
use Nwilging\LaravelDiscordBot\Support\Commands\Options\OptionChoice;
use Nwilging\LaravelDiscordBotTests\TestCase;
use Nwilging\LaravelDiscordBotTests\Traits\BasicCommandOptionTests;

class NumberOptionTest extends TestCase
{
    use BasicCommandOptionTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->expectedType = CommandOption::TYPE_NUMBER;
        $this->option = new NumberOption('option', 'desc');
    }

    public function testToArray()
    {
        $name = 'test-name';
        $description = 'test-desc';

        $option = new NumberOption($name, $description);

        $this->assertEquals([
            'type' => CommandOption::TYPE_NUMBER,
            'name' => $name,
            'description' => $description,
        ], $option->toArray());
    }

    public function testToArrayWithOptions()
    {
        $name = 'test-name';
        $description = 'test-desc';

        $option = new NumberOption($name, $description);

        $option->required()
            ->nameLocalizations(['l1'])
            ->descriptionLocalizations(['l2'])
            ->minValue(4.2)
            ->maxValue(142);

        $this->assertEquals([
            'type' => CommandOption::TYPE_NUMBER,
            'name' => $name,
            'description' => $description,
            'required' => true,
            'name_localizations' => ['l1'],
            'description_localizations' => ['l2'],
            'min_value' => 4.2,
            'max_value' => 142,
        ], $option->toArray());
    }

    public function testToArrayWithChoices()
    {
        $name = 'test-name';
        $description = 'test-desc';

        $option = new NumberOption($name, $description);

        $choice1 = new OptionChoice('choice1', '4.2');
        $choice2 = new OptionChoice('choice2', '52');
        $choice3 = new OptionChoice('choice3', '6.2');

        $option->choices([$choice1, $choice2, $choice3]);

        $this->assertEquals([
            'type' => CommandOption::TYPE_NUMBER,
            'name' => $name,
            'description' => $description,
            'choices' => [
                [
                    'name' => 'choice1',
                    'value' => 4.2,
                ],
                [
                    'name' => 'choice2',
                    'value' => 52,
                ],
                [
                    'name' => 'choice3',
                    'value' => 6.2,
                ],
            ],
        ], $option->toArray());
    }
}
