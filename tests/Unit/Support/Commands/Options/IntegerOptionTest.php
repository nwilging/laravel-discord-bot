<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Commands\Options;

use Nwilging\LaravelDiscordBot\Support\Commands\CommandOption;
use Nwilging\LaravelDiscordBot\Support\Commands\Options\IntegerOption;
use Nwilging\LaravelDiscordBot\Support\Commands\Options\OptionChoice;
use Nwilging\LaravelDiscordBotTests\TestCase;
use Nwilging\LaravelDiscordBotTests\Traits\BasicCommandOptionTests;

class IntegerOptionTest extends TestCase
{
    use BasicCommandOptionTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->expectedType = CommandOption::TYPE_INTEGER;
        $this->option = new IntegerOption('option', 'desc');
    }

    public function testToArray()
    {
        $name = 'test-name';
        $description = 'test-desc';

        $option = new IntegerOption($name, $description);

        $this->assertEquals([
            'type' => CommandOption::TYPE_INTEGER,
            'name' => $name,
            'description' => $description,
        ], $option->toArray());
    }

    public function testToArrayWithOptions()
    {
        $name = 'test-name';
        $description = 'test-desc';

        $option = new IntegerOption($name, $description);

        $option->required()
            ->nameLocalizations(['l1'])
            ->descriptionLocalizations(['l2'])
            ->minValue(42)
            ->maxValue(142);

        $this->assertEquals([
            'type' => CommandOption::TYPE_INTEGER,
            'name' => $name,
            'description' => $description,
            'required' => true,
            'name_localizations' => ['l1'],
            'description_localizations' => ['l2'],
            'min_value' => 42,
            'max_value' => 142,
        ], $option->toArray());
    }

    public function testToArrayWithChoices()
    {
        $name = 'test-name';
        $description = 'test-desc';

        $option = new IntegerOption($name, $description);

        $choice1 = new OptionChoice('choice1', '42');
        $choice2 = new OptionChoice('choice2', '52');
        $choice3 = new OptionChoice('choice3', '62');

        $option->choices([$choice1, $choice2, $choice3]);

        $this->assertEquals([
            'type' => CommandOption::TYPE_INTEGER,
            'name' => $name,
            'description' => $description,
            'choices' => [
                [
                    'name' => 'choice1',
                    'value' => 42,
                ],
                [
                    'name' => 'choice2',
                    'value' => 52,
                ],
                [
                    'name' => 'choice3',
                    'value' => 62,
                ],
            ],
        ], $option->toArray());
    }
}
