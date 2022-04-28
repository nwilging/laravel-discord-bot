<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Contracts\Support\Builder;

use Illuminate\Contracts\Support\Arrayable;
use Nwilging\LaravelDiscordBot\Support\Embed;

interface EmbedBuilderContract extends Arrayable
{
    /**
     * @return Embed[]
     */
    public function getEmbeds(): array;
}
