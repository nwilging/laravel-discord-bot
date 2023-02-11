<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Commands;

use Nwilging\LaravelDiscordBot\Support\Command;
use Nwilging\LaravelDiscordBot\Support\Commands\UserCommand;
use Nwilging\LaravelDiscordBotTests\TestCase;
use Nwilging\LaravelDiscordBotTests\Traits\BasicCommandTests;

class UserCommandTest extends TestCase
{
    use BasicCommandTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->expectedType = Command::TYPE_USER;
        $this->command = new UserCommand('test');
    }

    public function testToArray()
    {
        $name = 'test-name';
        $command = new UserCommand($name);

        $result = $command->toArray();
        $this->assertEquals([
            'type' => Command::TYPE_USER,
            'name' => $name,
        ], $result);
    }

    public function testToArrayWithOptions()
    {
        $name = 'test-name';
        $version = 'test-version';
        $defaultMemPermissions = 'test-perm';
        $parentAppId = 'test-app-id';

        $nameLocal = ['en-us'];
        $descLocal = ['es'];

        $command = new UserCommand($name);

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
            'type' => Command::TYPE_USER,
            'name' => $name,
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
}
