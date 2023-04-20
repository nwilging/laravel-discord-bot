<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Internal\Commands;

use Illuminate\Http\Request;
use Nwilging\LaravelDiscordBot\Events\ApplicationCommandInteractionEvent;

abstract class Command
{
    /**
     * The available types of application commands
     * @see https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-types
     */
    public const TYPE_CHAT_INPUT = 1;
    public const TYPE_USER = 2;
    public const TYPE_MESSAGE = 3;

    public function call(Request $request): void
    {
        $this->handle(new ApplicationCommandInteractionEvent($request->json()));
    }

    public abstract function handle(ApplicationCommandInteractionEvent $event): void;
}
