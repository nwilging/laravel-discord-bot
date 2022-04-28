<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Objects;

use Nwilging\LaravelDiscordBot\Support\Objects\AllowedMentionObject;
use Nwilging\LaravelDiscordBotTests\TestCase;

class AllowedMentionObjectTest extends TestCase
{
    public function testObject()
    {
        $object = new AllowedMentionObject();
        $this->assertEquals([], $object->toArray());
    }

    public function testObjectWithParseOption()
    {
        $object = new AllowedMentionObject();

        $object->allowRolesMention();
        $this->assertEquals([
            'parse' => [AllowedMentionObject::MENTIONS_ROLES],
        ], $object->toArray());

        $object->allowUsersMention();
        $this->assertEquals([
            'parse' => [AllowedMentionObject::MENTIONS_ROLES, AllowedMentionObject::MENTIONS_USERS],
        ], $object->toArray());

        $object->allowEveryoneMention();
        $this->assertEquals([
            'parse' => [AllowedMentionObject::MENTIONS_ROLES, AllowedMentionObject::MENTIONS_USERS, AllowedMentionObject::MENTIONS_EVERYONE],
        ], $object->toArray());
    }

    public function testObjectWithAdditionalOptions()
    {
        $object = new AllowedMentionObject();

        $object->allowMentionsForRoles(['role-1', 'role-2']);
        $object->allowMentionsForUsers(['user-1', 'user-2']);
        $object->mentionReplyUser();

        $this->assertEquals([
            'replied_user' => true,
            'roles' => ['role-1', 'role-2'],
            'users' => ['user-1', 'user-2'],
        ], $object->toArray());
    }
}
