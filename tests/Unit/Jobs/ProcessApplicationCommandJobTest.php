<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Jobs;

use Illuminate\Contracts\Foundation\Application;
use Mockery\MockInterface;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandContract;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandManagerContract;
use Nwilging\LaravelDiscordBot\Events\ApplicationCommandInteractionEvent;
use Nwilging\LaravelDiscordBot\Jobs\ProcessApplicationCommandJob;
use Nwilging\LaravelDiscordBot\Support\Command;
use Nwilging\LaravelDiscordBotTests\TestCase;

class ProcessApplicationCommandJobTest extends TestCase
{
    public function testHandle()
    {
        $type = Command::TYPE_CHAT_INPUT;
        $signature = 'test-signature';
        $event = \Mockery::mock(ApplicationCommandInteractionEvent::class);

        $commandManager = \Mockery::mock(CommandManagerContract::class);
        $laravel = \Mockery::mock(Application::class);

        $command = $this->testCommand();
        $commandManager->shouldReceive('get')
            ->once()
            ->with($type, $signature)
            ->andReturn($command);

        $laravel->shouldReceive('call')
            ->once()
            ->with([$command, 'handle']);

        $job = new ProcessApplicationCommandJob($type, $signature, $event);
        $job->handle($commandManager, $laravel);
    }

    public function testHandleDoesNothingWhenNoHandleMethod()
    {
        $type = Command::TYPE_CHAT_INPUT;
        $signature = 'test-signature';
        $event = \Mockery::mock(ApplicationCommandInteractionEvent::class);

        $commandManager = \Mockery::mock(CommandManagerContract::class);
        $laravel = \Mockery::mock(Application::class);

        $command = \Mockery::mock(CommandContract::class);
        $commandManager->shouldReceive('get')
            ->once()
            ->with($type, $signature)
            ->andReturn($command);

        $job = new ProcessApplicationCommandJob($type, $signature, $event);
        $job->handle($commandManager, $laravel);
    }

    protected function testCommand(): MockInterface
    {
        $command = new class implements CommandContract {
            public static function signature(): string
            {
                return 'test';
            }

            public static function description(): string
            {
                return 'test';
            }

            public static function guildId(): ?string
            {
                return null;
            }

            public static function type(): int
            {
                return 1;
            }

            public static function migrate(): Command
            {
                return \Mockery::mock(Command::class);
            }

            public function setEvent(ApplicationCommandInteractionEvent $event): void
            {
                //
            }

            public function handle(): void
            {
                //
            }
        };

        return \Mockery::mock($command);
    }
}
