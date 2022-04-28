<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Embeds;

use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

/**
 * Field Embed
 * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-field-structure
 */
class FieldEmbed extends Embed
{
    use MergesArrays;

    protected string $name;

    protected string $value;

    protected ?bool $inline = null;

    public function __construct(string $name, string $value, ?string $title = null, ?string $description = null, ?string $timestamp = null)
    {
        parent::__construct($title, $description, $timestamp);

        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Whether this field should display inline
     *
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-field-structure
     * @param bool $inline
     * @return $this
     */
    public function inline(bool $inline = true): self
    {
        $this->inline = $inline;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_FIELD;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'field' => [
                'name' => $this->name,
                'value' => $this->value,
                'inline' => $this->inline,
            ],
        ]);
    }
}
