<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Commands;

use Illuminate\Contracts\Support\Arrayable;
use Nwilging\LaravelDiscordBot\Support\Commands\Options\OptionChoice;
use Nwilging\LaravelDiscordBot\Support\Traits\FiltersRecursive;

/**
 * Application Command Option
 * @see https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-structure
 */
abstract class CommandOption implements Arrayable
{
    use FiltersRecursive;

    /**
     * The available command option types
     * @see https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-type
     */
    public const TYPE_SUB_COMMAND = 1;
    public const TYPE_SUB_COMMAND_GROUP = 2;
    public const TYPE_STRING = 3;
    public const TYPE_INTEGER = 4;
    public const TYPE_BOOLEAN = 5;
    public const TYPE_USER = 6;
    public const TYPE_CHANNEL = 7;
    public const TYPE_ROLE = 8;
    public const TYPE_MENTIONABLE = 9;
    public const TYPE_NUMBER = 10;
    public const TYPE_ATTACHMENT = 11;

    protected string $name;

    protected string $description;

    protected ?array $nameLocalizations = null;

    protected ?array $descriptionLocalizations = null;

    protected ?bool $required = null;

    /**
     * @var int[]|null
     */
    protected ?array $channelTypes = null;

    public function __construct(string $name, string $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    public abstract function getType(): int;

    protected abstract function choiceTransformer(OptionChoice $choice): array;

    public function toArray(): array
    {
        return $this->arrayFilterRecursive([
            'type' => $this->getType(),
            'name' => $this->name,
            'description' => $this->description,
            'required' => $this->required,
            'name_localizations' => $this->nameLocalizations,
            'description_localizations' => $this->descriptionLocalizations,
        ]);
    }
}
