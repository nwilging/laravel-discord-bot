<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Events;

class ApplicationCommandInteractionEvent extends AbstractInteractionEvent
{
    protected function getData(): array
    {
        return $this->interactionRequest->get('data', []);
    }

    public function getCommandName(): string
    {
        return $this->getData()['name'];
    }

    public function getCommandId(): string
    {
        return $this->getData()['id'];
    }

    public function getCommandType(): int
    {
        return (int) $this->getData()['type'];
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
