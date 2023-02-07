<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support;

use Illuminate\Contracts\Support\Arrayable;
use Nwilging\LaravelDiscordBot\Support\Traits\FiltersRecursive;

/**
 * Abstract application command
 * @see https://discord.com/developers/docs/interactions/application-commands#application-command-object
 */
abstract class Command implements Arrayable
{
    use FiltersRecursive;

    /**
     * The available types of application commands
     * @see https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-types
     */
    public const TYPE_CHAT_INPUT = 1;
    public const TYPE_USER = 2;
    public const TYPE_MESSAGE = 3;

    protected string $name;

    protected ?string $parentApplicationId = null;

    protected ?array $nameLocalizations = null;

    protected ?array $descriptionLocalizations = null;

    protected ?string $defaultMemberPermissions = null;

    protected ?bool $dmPermission = null;

    protected ?bool $defaultPermission = null;

    protected ?bool $nsfw = null;

    protected ?string $version = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function parentApplication(string $applicationId): self
    {
        $this->parentApplicationId = $applicationId;
        return $this;
    }

    public function nameLocalizations(array $localizations): self
    {
        $this->nameLocalizations = $localizations;
        return $this;
    }

    public function descriptionLocalizations(array $localizations): self
    {
        $this->descriptionLocalizations = $localizations;
        return $this;
    }

    /**
     * Set of permissions represented as a bit set
     *
     * @see https://discord.com/developers/docs/topics/permissions
     *
     * @param string $permission
     * @return $this
     */
    public function defaultMemberPermissions(string $permission): self
    {
        $this->defaultMemberPermissions = $permission;
        return $this;
    }

    public function dmPermission(bool $enable = true): self
    {
        $this->dmPermission = $enable;
        return $this;
    }

    public function defaultPermission(bool $enable = true): self
    {
        $this->defaultPermission = $enable;
        return $this;
    }

    public function nsfw(bool $enable = true): self
    {
        $this->nsfw = $enable;
        return $this;
    }

    public function version(string $version): self
    {
        $this->version = $version;
        return $this;
    }

    public abstract function getType(): int;

    public function toArray(): array
    {
        return $this->arrayFilterRecursive([
            'type' => $this->getType(),
            'name' => $this->name,
            'application_id' => $this->parentApplicationId,
            'name_localizations' => $this->nameLocalizations,
            'description_localizations' => $this->descriptionLocalizations,
            'default_member_permissions' => $this->defaultMemberPermissions,
            'dm_permission' => $this->dmPermission,
            'default_permission' => $this->defaultPermission,
            'nsfw' => $this->nsfw,
            'version' => $this->version,
        ]);
    }
}
