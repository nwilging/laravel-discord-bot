<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Commands;

use Nwilging\LaravelDiscordBot\Support\Command;
use Nwilging\LaravelDiscordBot\Support\Commands\CommandOption;
use Nwilging\LaravelDiscordBot\Support\Commands\MessageCommand;
use Nwilging\LaravelDiscordBot\Support\Commands\SlashCommand;
use Nwilging\LaravelDiscordBotTests\TestCase;
use Nwilging\LaravelDiscordBotTests\Traits\BasicCommandTests;

class SlashCommandTest extends TestCase
{
    use BasicCommandTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->expectedType = Command::TYPE_CHAT_INPUT;
        $this->command = new SlashCommand('test', 'desc');
    }

    public function testToArray()
    {
        $name = 'test-name';
        $description = 'test description';

        $command = new SlashCommand($name, $description);

        $result = $command->toArray();
        $this->assertEquals([
            'type' => Command::TYPE_CHAT_INPUT,
            'name' => $name,
            'description' => $description,
        ], $result);
    }

    public function testToArrayWithOptions()
    {
        $name = 'test-name';
        $description = 'test description';
        $version = 'test-version';
        $defaultMemPermissions = 'test-perm';
        $parentAppId = 'test-app-id';

        $nameLocal = ['en-us'];
        $descLocal = ['es'];

        $command = new SlashCommand($name, $description);

        $command->version($version);
        $command->dmPermission();
        $command->defaultPermission();
        $command->defaultMemberPermissions($defaultMemPermissions);
        $command->nsfw();
        $command->parentApplication($parentAppId);

        $command->nameLocalizations($nameLocal);
        $command->descriptionLocalizations($descLocal);

        $result = $command->toArray();
        $this->assertEquals([
            'type' => Command::TYPE_CHAT_INPUT,
            'name' => $name,
            'description' => $description,
            'application_id' => $parentAppId,
            'default_member_permissions' => $defaultMemPermissions,
            'dm_permission' => true,
            'default_permission' => true,
            'nsfw' => true,
            'version' => $version,
            'name_localizations' => $nameLocal,
            'description_localizations' => $descLocal,
        ], $result);
    }

    public function testToArrayWithAdditionalOptions()
    {
        $name = 'test-name';
        $description = 'test description';

        $optionArray = [
            'key' => 'value',
        ];

        $option2Array = [
            'another' => 'value',
        ];

        $command = new SlashCommand($name, $description);

        $option1 = \Mockery::mock(CommandOption::class);
        $option1->shouldReceive('toArray')
            ->once()
            ->andReturn($optionArray);

        $option2 = \Mockery::mock(CommandOption::class);
        $option2->shouldReceive('toArray')
            ->once()
            ->andReturn($option2Array);

        $command->option($option1);
        $command->option($option2);

        $result = $command->toArray();
        $this->assertEquals([
            'type' => Command::TYPE_CHAT_INPUT,
            'name' => $name,
            'description' => $description,
            'options' => [$optionArray, $option2Array],
        ], $result);
    }
}
