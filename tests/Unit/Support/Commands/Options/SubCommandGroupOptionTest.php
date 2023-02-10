<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Commands\Options;

use Nwilging\LaravelDiscordBot\Support\Commands\CommandOption;
use Nwilging\LaravelDiscordBot\Support\Commands\Options\SubCommandGroupOption;
use Nwilging\LaravelDiscordBotTests\TestCase;
use Nwilging\LaravelDiscordBotTests\Traits\BasicCommandOptionTests;

class SubCommandGroupOptionTest extends TestCase
{
    use BasicCommandOptionTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->expectedType = CommandOption::TYPE_SUB_COMMAND_GROUP;
        $this->option = new SubCommandGroupOption('option', 'desc');
    }

    public function testToArray()
    {
        $name = 'test-name';
        $description = 'test-desc';

        $option = new SubCommandGroupOption($name, $description);

        $this->assertEquals([
            'type' => CommandOption::TYPE_SUB_COMMAND_GROUP,
            'name' => $name,
            'description' => $description,
        ], $option->toArray());
    }

    public function testToArrayWithOptions()
    {
        $name = 'test-name';
        $description = 'test-desc';

        $option = new SubCommandGroupOption($name, $description);

        $option->required()
            ->nameLocalizations(['l1'])
            ->descriptionLocalizations(['l2']);

        $this->assertEquals([
            'type' => CommandOption::TYPE_SUB_COMMAND_GROUP,
            'name' => $name,
            'description' => $description,
            'required' => true,
            'name_localizations' => ['l1'],
            'description_localizations' => ['l2'],
        ], $option->toArray());
    }
}
