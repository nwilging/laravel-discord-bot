<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support;

use Illuminate\Contracts\Support\Arrayable;
use Nwilging\LaravelDiscordBot\Support\Traits\FiltersRecursive;

/**
 * Abstract Message Component
 * @see https://discord.com/developers/docs/interactions/message-components#component-object
 */
abstract class Component implements Arrayable
{
    use FiltersRecursive;

    public const TYPE_ACTION_ROW = 1;
    public const TYPE_BUTTON = 2;
    public const TYPE_SELECT_MENU = 3;
    public const TYPE_TEXT_INPUT = 4;

    protected ?string $customId = null;

    protected function __construct(?string $customId = null)
    {
        $this->customId = $customId;
    }

    public abstract function getType(): int;

    /**
     * Returns a Discord-API compliant component array
     *
     * @see https://discord.com/developers/docs/interactions/message-components#component-object
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->arrayFilterRecursive([
            'type' => $this->getType(),
            'custom_id' => $this->customId,
        ]);
    }
}
