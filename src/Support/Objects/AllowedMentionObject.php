<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Objects;

use Nwilging\LaravelDiscordBot\Support\SupportObject;
use Nwilging\LaravelDiscordBot\Support\Traits\MergesArrays;

/**
 * Allowed Mentions Object
 * @see https://discord.com/developers/docs/resources/channel#allowed-mentions-object
 */
class AllowedMentionObject extends SupportObject
{
    use MergesArrays;

    public const MENTIONS_ROLES = 'roles';
    public const MENTIONS_USERS = 'users';
    public const MENTIONS_EVERYONE = 'everyone';

    protected array $parse = [];

    protected ?array $roles = null;

    protected ?array $users = null;

    protected ?bool $repliedUser = null;

    /**
     * For replies, whether to mention the author of the message being replied to
     *
     * @see https://discord.com/developers/docs/resources/channel#allowed-mentions-object-allowed-mentions-structure
     * @param bool $mention
     * @return $this
     */
    public function mentionReplyUser(bool $mention = true): self
    {
        $this->repliedUser = $mention;
        return $this;
    }

    /**
     * Allows roles to be mentioned in message
     *
     * @see https://discord.com/developers/docs/resources/channel#allowed-mentions-object-allowed-mention-types
     * @return $this
     */
    public function allowRolesMention(): self
    {
        if (!in_array(static::MENTIONS_ROLES, $this->parse)) {
            $this->parse[] = static::MENTIONS_ROLES;
        }

        return $this;
    }

    /**
     * Allows users to be mentioned in message
     *
     * @see https://discord.com/developers/docs/resources/channel#allowed-mentions-object-allowed-mention-types
     * @return $this
     */
    public function allowUsersMention(): self
    {
        if (!in_array(static::MENTIONS_USERS, $this->parse)) {
            $this->parse[] = static::MENTIONS_USERS;
        }

        return $this;
    }

    /**
     * Allows everyone to be mentioned in message
     *
     * @see https://discord.com/developers/docs/resources/channel#allowed-mentions-object-allowed-mention-types
     * @return $this
     */
    public function allowEveryoneMention(): self
    {
        if (!in_array(static::MENTIONS_EVERYONE, $this->parse)) {
            $this->parse[] = static::MENTIONS_EVERYONE;
        }

        return $this;
    }

    /**
     * Allows mentions of specific roles
     *
     * @see https://discord.com/developers/docs/resources/channel#allowed-mentions-object-allowed-mentions-structure
     * @param array $roles
     * @return $this
     */
    public function allowMentionsForRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Allows mentions of specific users
     *
     * @see https://discord.com/developers/docs/resources/channel#allowed-mentions-object-allowed-mentions-structure
     * @param array $users
     * @return $this
     */
    public function allowMentionsForUsers(array $users): self
    {
        $this->users = $users;
        return $this;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'parse' => $this->parse,
            'roles' => $this->roles,
            'users' => $this->users,
            'replied_user' => $this->repliedUser,
        ]);
    }
}
