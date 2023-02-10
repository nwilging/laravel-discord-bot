<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Commands\Options;

use Nwilging\LaravelDiscordBot\Support\Commands\CommandOption;
use Nwilging\LaravelDiscordBot\Support\Commands\Options\OptionChoice;
use Nwilging\LaravelDiscordBot\Support\Commands\Options\StringOption;
use Nwilging\LaravelDiscordBotTests\TestCase;
use Nwilging\LaravelDiscordBotTests\Traits\BasicCommandOptionTests;

class StringOptionTest extends TestCase
{
    use BasicCommandOptionTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->expectedType = CommandOption::TYPE_STRING;
        $this->option = new StringOption('option', 'desc');
    }

    public function testToArray()
    {
        $name = 'test-name';
        $description = 'test-desc';

        $option = new StringOption($name, $description);

        $this->assertEquals([
            'type' => CommandOption::TYPE_STRING,
            'name' => $name,
            'description' => $description,
        ], $option->toArray());
    }

    public function testToArrayWithOptions()
    {
        $name = 'test-name';
        $description = 'test-desc';

        $option = new StringOption($name, $description);

        $option->required()
            ->nameLocalizations(['l1'])
            ->descriptionLocalizations(['l2'])
            ->maxLength(123)
            ->autocomplete();

        $this->assertEquals([
            'type' => CommandOption::TYPE_STRING,
            'name' => $name,
            'description' => $description,
            'required' => true,
            'name_localizations' => ['l1'],
            'description_localizations' => ['l2'],
            'max_length' => 123,
            'autocomplete' => true,
        ], $option->toArray());
    }

    public function testToArrayWithChoices()
    {
        $name = 'test-name';
        $description = 'test-desc';

        $option = new StringOption($name, $description);

        $choice1 = new OptionChoice('choice1', 'test');
        $choice2 = new OptionChoice('choice2', 'test2');
        $choice3 = new OptionChoice('choice3', 'test3');

        $option->choice($choice1);
        $option->choice($choice2);
        $option->choice($choice3);

        $this->assertEquals([
            'type' => CommandOption::TYPE_STRING,
            'name' => $name,
            'description' => $description,
            'choices' => [
                [
                    'name' => 'choice1',
                    'value' => 'test',
                ],
                [
                    'name' => 'choice2',
                    'value' => 'test2',
                ],
                [
                    'name' => 'choice3',
                    'value' => 'test3',
                ],
            ],
        ], $option->toArray());
    }
}
