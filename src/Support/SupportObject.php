<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support;

use Illuminate\Contracts\Support\Arrayable;
use Nwilging\LaravelDiscordBot\Support\Traits\FiltersRecursive;

abstract class SupportObject implements Arrayable
{
    use FiltersRecursive;

    public function toArray(): array
    {
        return $this->arrayFilterRecursive([]);
    }
}
