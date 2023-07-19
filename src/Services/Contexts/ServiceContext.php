<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Services\Contexts;

use Nwilging\LaravelDiscordBot\Contracts\Services\Contexts\ServiceContextFactoryContract;

abstract class ServiceContext
{
    protected ServiceContextFactoryContract $contextFactory;

    public function __construct(ServiceContextFactoryContract $contextFactory)
    {
        $this->contextFactory = $contextFactory;
    }

    protected function makeContext(string $context, array $args = []): ServiceContext
    {
        return $this->contextFactory->make($context, $args);
    }
}
