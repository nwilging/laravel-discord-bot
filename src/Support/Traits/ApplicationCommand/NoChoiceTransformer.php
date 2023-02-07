<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Traits\ApplicationCommand;

use Nwilging\LaravelDiscordBot\Support\Commands\Options\OptionChoice;

trait NoChoiceTransformer
{
    public function choiceTransformer(OptionChoice $choice): array
    {
        return $choice->toArray();
    }
}
