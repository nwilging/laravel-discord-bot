<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Traits;

trait MergesArrays
{
    protected function toMergedArray(array $toMerge): array
    {
        return $this->arrayFilterRecursive(array_merge(parent::toArray(), $toMerge));
    }
}
