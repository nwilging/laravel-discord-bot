<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Models\Api;

class GuildMember
{
    public ?User $user;

    public ?string $nick;

    public ?array $roles;

    public ?string $joinedAt;

    public ?string $premiumSince;

    public ?bool $deaf;

    public ?bool $mute;

    public ?bool $pending;

    public ?string $permissions;

    public ?string $avatar;

    public ?int $flags;

    public ?string $communicationDisabledUntil;
}
