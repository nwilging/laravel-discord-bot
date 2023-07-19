<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Traits\Services\Contexts;

trait ReadAbility
{
    public function read(): array
    {
        return $this->readMethod()();
    }

    protected abstract function readMethod(): \Closure;
}
