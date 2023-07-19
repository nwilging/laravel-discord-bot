<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Models\Api;

class ThreadMember
{
    public ?string $id;

    public ?string $userId;

    public ?string $joinTimestamp;

    public ?int $flags;
}
