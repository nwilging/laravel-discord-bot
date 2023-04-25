# Application Commands

Discord supports various types of commands, including slash commands (also called
"chat input" commands), message commands, and user commands.

## Table of Contents

1. [Create a command handler](#create-a-command-handler)
2. [Example Command](#example-command)
3. [Queueing commands](#queueing-commands)

## Create a command handler

When a user invokes your command, you will receive an interaction event. In order to handle
this event as a command, you will need to create a command handler.

Command handlers are structured similarly to Laravel Commands. They have a `handle` method
that is called when the command is invoked. However, the implementation of `signature` and
`description` deviate a little bit.

Command handlers should:
1. Extend the abstract `Command` class: `Nwilging\LaravelDiscordBot\Support\Internal\Commands\Command`
2. Implement the `CommandContract` interface: `Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandContract`

The handler requires a set of static methods:
* `signature()`
* `description()`
* `guildId()`
* `type()`
* `migrate()`

#### `static sigature()` method

Return the name of the command -- the command signature -- here. This is the name that
will be used to invoke the command. For example, with slash commands, if you return
`test-command` from this method, then your command will be invoked with `/test-command`.

Likewise, for Message Commands, the command will appear under the message context menu
as `test-command`.

#### `static description()` method

Return a description of the command here. This is the description that will be shown
in the Discord client when the user is selecting a command to invoke.

#### `static guildId()` method

This is an optional method. If you want to limit the command to a specific guild, you
can return the guild ID here. If you do not want to limit the command to a specific guild,
you can return `null` from this method.

#### `static type()` method

Return the type of the command, one of:
* `Command::TYPE_CHAT_INPUT`
* `Command::TYPE_USER`
* `Command::TYPE_MESSAGE`

#### `static migrate()` method

Build and return the command class here, using the command builder helpers. When your
commands are migrated, this method will be called to generate the payload to send
to Discord.

### The `handle` method

The `handle` method is called when the command is invoked. It is called within the Laravel
Application Container, so you may use dependency injection here.

## Example Command

```php
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandContract;
use Nwilging\LaravelDiscordBot\Models\WebhookMessage;
use Nwilging\LaravelDiscordBot\Support\Command;
use Nwilging\LaravelDiscordBot\Support\Commands\Options\StringOption;
use Nwilging\LaravelDiscordBot\Support\Commands\SlashCommand;
use Nwilging\LaravelDiscordBot\Support\Internal\Commands\Command as DiscordCommand;
use Psr\Log\LoggerInterface;

class TestAppCommand extends DiscordCommand implements CommandContract
{
    public function handle(LoggerInterface $log): void
    {
        $message = new WebhookMessage();
        $message->content = 'test response';

        $this->sendFollowupMessage($message);
    }

    public static function signature(): string
    {
        return 'test-command';
    }

    public static function description(): string
    {
        return 'A testing command';
    }

    public static function guildId(): ?string
    {
        // This command will be created as a "global" command, available in all guilds
        return null;
    }

    public static function type(): int
    {
        // This value must match the type of command returned below
        return static::TYPE_CHAT_INPUT;
    }

    public static function migrate(): Command
    {
        $cmd = new SlashCommand(
            static::signature(),
            static::description(),
        );

        $option = new StringOption('test-option', 'string option');
        $option2 = new StringOption('test-option2', 'string option');

        $cmd->option($option);
        $cmd->option($option2);

        return $cmd;
    }
}
```

## Queueing Commands

To queue a command, simply add the `ShouldQueue` interface to your command handler. The
command will be queued and processed by the Laravel queue worker.

```php
use Illuminate\Contracts\Queue\ShouldQueue;

class TestAppCommand extends DiscordCommand implements CommandContract, ShouldQueue
{
    // ...
}
```
