<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Events;

use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\ParameterBag;

class MessageComponentInteractionEvent
{
    use SerializesModels;

    protected ParameterBag $interactionRequest;

    public function __construct(ParameterBag $interactionRequest)
    {
        $this->interactionRequest = $interactionRequest;
    }

    public function getInteractionRequest(): ParameterBag
    {
        return $this->interactionRequest;
    }
}
