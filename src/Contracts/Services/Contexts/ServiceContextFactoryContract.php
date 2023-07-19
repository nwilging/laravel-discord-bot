<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Contracts\Services\Contexts;

use Nwilging\LaravelDiscordBot\Services\Contexts\ServiceContext;

interface ServiceContextFactoryContract
{
    public function make(string $context, array $args = []): ServiceContext;
}
