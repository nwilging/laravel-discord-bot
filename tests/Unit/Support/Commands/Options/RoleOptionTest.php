<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Commands\Options;

use Nwilging\LaravelDiscordBot\Support\Commands\CommandOption;
use Nwilging\LaravelDiscordBot\Support\Commands\Options\RoleOption;
use Nwilging\LaravelDiscordBotTests\TestCase;
use Nwilging\LaravelDiscordBotTests\Traits\BasicCommandOptionTests;

class RoleOptionTest extends TestCase
{
    use BasicCommandOptionTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->expectedType = CommandOption::TYPE_ROLE;
        $this->option = new RoleOption('option', 'desc');
    }

    public function testToArray()
    {
        $name = 'test-name';
        $description = 'test-desc';

        $option = new RoleOption($name, $description);

        $this->assertEquals([
            'type' => CommandOption::TYPE_ROLE,
            'name' => $name,
            'description' => $description,
        ], $option->toArray());
    }

    public function testToArrayWithOptions()
    {
        $name = 'test-name';
        $description = 'test-desc';

        $option = new RoleOption($name, $description);

        $option->required()
            ->nameLocalizations(['l1'])
            ->descriptionLocalizations(['l2']);

        $this->assertEquals([
            'type' => CommandOption::TYPE_ROLE,
            'name' => $name,
            'description' => $description,
            'required' => true,
            'name_localizations' => ['l1'],
            'description_localizations' => ['l2'],
        ], $option->toArray());
    }
}
