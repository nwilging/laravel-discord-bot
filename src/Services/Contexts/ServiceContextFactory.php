<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Services\Contexts;

use Illuminate\Contracts\Foundation\Application;
use Nwilging\LaravelDiscordBot\Contracts\Services\Contexts\ServiceContextFactoryContract;

class ServiceContextFactory implements ServiceContextFactoryContract
{
    protected Application $container;

    public function __construct(Application $container)
    {
        $this->container = $container;
    }

    public function make(string $context, array $args = []): ServiceContext
    {
        return $this->container->make($context, $args);
    }
}
