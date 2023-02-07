<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Events;

class ApplicationCommandInteractionEvent extends AbstractInteractionEvent
{
    public function getCommandName(): string
    {
        return $this->interactionRequest->get('data.name');
    }

    public function getCommandId(): string
    {
        return $this->interactionRequest->get('data.id');
    }

    public function getCommandType(): int
    {
        return (int) $this->interactionRequest->get('data.type');
    }

    public function getChannelId(): string
    {
        return $this->interactionRequest->get('channel_id');
    }

    public function getApplicationId(): string
    {
        return $this->interactionRequest->get('application_id');
    }
}
