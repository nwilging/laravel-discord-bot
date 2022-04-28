<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Interactions;

use Illuminate\Contracts\Support\Arrayable;

class DiscordInteractionResponse implements Arrayable
{
    protected int $status;

    protected int $type;

    protected ?array $data;

    public function __construct(int $type, ?array $data = null, ?int $status = 200)
    {
        $this->status = $status;
        $this->type = $type;
        $this->data = $data;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return array_filter([
            'type' => $this->type,
            'data' => $this->data,
        ]);
    }
}
