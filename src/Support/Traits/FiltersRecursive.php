<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Traits;

trait FiltersRecursive
{
    protected function arrayFilterRecursive(array $toFilter): array
    {
        foreach ($toFilter as $key => $value) {
            if (is_array($value)) {
                $toFilter[$key] = $this->arrayFilterRecursive($value);
            }
        }

        return array_filter($toFilter);
    }
}
