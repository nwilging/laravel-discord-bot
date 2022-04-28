<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Builder;

use Nwilging\LaravelDiscordBot\Support\Component;
use Nwilging\LaravelDiscordBot\Support\Components\ActionRow;
use Nwilging\LaravelDiscordBot\Support\Components\ButtonComponent;
use Nwilging\LaravelDiscordBot\Support\Components\LinkButtonComponent;
use Nwilging\LaravelDiscordBot\Support\Components\ParagraphTextInputComponent;
use Nwilging\LaravelDiscordBot\Support\Components\SelectMenuComponent;
use Nwilging\LaravelDiscordBot\Support\Components\ShortTextInputComponent;
use Nwilging\LaravelDiscordBot\Support\Objects\SelectOptionObject;

class ComponentBuilder
{
    protected array $components = [];

    public function addComponent(Component $component): self
    {
        $this->components[] = $component;
        return $this;
    }

    public function addActionButton(string $label, string $customId): self
    {
        $this->components[] = new ButtonComponent($label, $customId);
        return $this;
    }

    public function addLinkButton(string $label, string $url): self
    {
        $this->components[] = new LinkButtonComponent($label, $url);
        return $this;
    }

    /**
     * @param SelectOptionObject[] $options
     * @param string $customId
     * @return SelectMenuComponent
     */
    public function addSelectMenuComponent(array $options, string $customId): self
    {
        $this->components[] = new SelectMenuComponent($customId, $options);
        return $this;
    }

    public function withSelectOptionObject(string $label, string $value): SelectOptionObject
    {
        return new SelectOptionObject($label, $value);
    }

    public function addShortTextInput(string $label, string $customId): self
    {
        $this->components[] = new ShortTextInputComponent($label, $customId);
        return $this;
    }

    public function addParagraphTextInput(string $label, string $customId): self
    {
        $this->components[] = new ParagraphTextInputComponent($label, $customId);
        return $this;
    }

    public function getActionRow(): ActionRow
    {
        return new ActionRow($this->components);
    }
}
