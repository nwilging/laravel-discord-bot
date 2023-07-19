<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Models\Api;

use Nwilging\LaravelDiscordBot\Traits\Models\Api\SnowflakeId;

class User
{
    use SnowflakeId;

    public ?string $username;

    public ?string $discriminator;

    public ?string $avatar;

    public ?bool $bot;

    public ?bool $system;

    public ?bool $mfaEnabled;

    public ?string $banner;

    public ?string $accentColor;

    public ?string $locale;

    public ?bool $verified;

    public ?string $email;

    public ?int $flags;

    public ?int $premiumType;

    public ?int $publicFlags;
}
