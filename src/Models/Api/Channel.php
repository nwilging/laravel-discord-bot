<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Models\Api;

use Nwilging\LaravelDiscordBot\Traits\Models\Api\SnowflakeId;

class Channel
{
    use SnowflakeId;

    public int $type;

    public ?string $guildId;

    public ?int $position;

    public ?array $permissionOverwrites;

    public ?string $name;

    public ?string $topic;

    public ?bool $nsfw;

    public ?string $lastMessageId;

    public ?int $bitrate;

    public ?int $userLimit;

    public ?int $rateLimitPerUser;

    /**
     * @var User[]
     */
    public array $recipients = [];

    public ?string $icon;

    public ?string $ownerId;

    public ?string $applicationId;

    public ?bool $managed;

    public ?string $parentId;

    public ?string $lastPinTimestamp;

    public ?string $rtcRegion;

    public ?int $videoQualityMode;

    public ?int $messageCount;

    public ?int $memberCount;

    public ?array $threadMetadata;

    public ?array $member;

    public ?int $defaultAutoArchiveDuration;

    public ?string $permissions;

    public ?int $flags;

    public ?int $totalMessageSent;

    public array $availableTags = [];

    public array $appliedTags = [];

    public ?array $defaultReactionEmoji;

    public ?int $defaultThreadRateLimitPerUser;

    public ?int $defaultSortOrder;

    public ?int $defaultForumLayout;
}
