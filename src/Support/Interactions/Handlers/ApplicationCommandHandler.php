<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Interactions\Handlers;

use Illuminate\Contracts\Bus\Dispatcher as JobDispatcher;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Nwilging\LaravelDiscordBot\Contracts\Listeners\ApplicationCommandInteractionEventListenerContract;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandContract;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandManagerContract;
use Nwilging\LaravelDiscordBot\Events\ApplicationCommandInteractionEvent;
use Nwilging\LaravelDiscordBot\Jobs\ProcessApplicationCommandJob;
use Nwilging\LaravelDiscordBot\Support\Interactions\DiscordInteractionResponse;
use Nwilging\LaravelDiscordBot\Support\Interactions\InteractionHandler;
use Nwilging\LaravelDiscordBot\Support\Internal\Commands\Command;
use Nwilging\LaravelDiscordBot\Support\Traits\HasInteractionListeners;

class ApplicationCommandHandler extends InteractionHandler
{
    use HasInteractionListeners;

    protected string $defaultBehavior;

    protected CommandManagerContract $commandManager;

    protected JobDispatcher $jobDispatcher;

    public function __construct(
        string $defaultBehavior,
        CommandManagerContract $commandManager,
        EventDispatcher $dispatcher,
        JobDispatcher $jobDispatcher,
        Application $laravel
    ) {
        $this->defaultBehavior = $defaultBehavior;
        $this->commandManager = $commandManager;
        $this->dispatcher = $dispatcher;
        $this->jobDispatcher = $jobDispatcher;
        $this->laravel = $laravel;
    }

    public function handle(Request $request): DiscordInteractionResponse
    {
        if ($response = $this->shouldHandleEventExternally($request)) {
            return $response;
        }

        return $this->defaultBehavior();
    }

    protected function shouldHandleEventExternally(Request $request): ?DiscordInteractionResponse
    {
        $event = new ApplicationCommandInteractionEvent($request->json());

        $type = $event->getCommandType();
        $signature = $event->getCommandName();

        $command = null;
        try {
            $command = $this->commandManager->get($type, $signature);
        } catch (\InvalidArgumentException $e) {
            // command does not exist
        }

        /** @var Command $command */
        if ($command && method_exists($command, 'handle')) {
            if ($command instanceof ShouldQueue) {
                $this->jobDispatcher->dispatch(new ProcessApplicationCommandJob(
                    $type,
                    $signature,
                    $event
                ));
            } else {
                $command->setEvent($event);
                $this->laravel->call([$command, 'handle']);
            }
        }

        return new DiscordInteractionResponse(static::RESPONSE_TYPE_DEFERRED_CHANNEL_MESSAGE_WITH_SOURCE);
    }
}
