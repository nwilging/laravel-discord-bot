<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Enums;

class ChannelType
{
    public const GUILD_TEXT = 0;
    public const DM = 1;
    public const GUILD_VOICE = 2;
    public const GROUP_DM = 3;
    public const GUILD_CATEGORY = 4;
    public const GUILD_ANNOUNCEMENT = 5;
    public const ANNOUNCEMENT_THREAD = 10;
    public const PUBLIC_THREAD = 11;
    public const PRIVATE_THREAD = 12;
    public const GUILD_STAGE_VOICE = 13;
    public const GUILD_DIRECTORY = 14;
    public const GUILD_FORUM = 15;
}
