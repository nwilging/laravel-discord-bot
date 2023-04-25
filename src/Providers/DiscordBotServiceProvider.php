<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Nwilging\LaravelDiscordBot\Channels\DiscordNotificationChannel;
use Nwilging\LaravelDiscordBot\Contracts\Channels\DiscordNotificationChannelContract;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordApiServiceContract;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordApplicationCommandServiceContract;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordInteractionServiceContract;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordInteractionWebhooksServiceContract;
use Nwilging\LaravelDiscordBot\Services\DiscordApiService;
use Nwilging\LaravelDiscordBot\Services\DiscordApplicationCommandService;
use Nwilging\LaravelDiscordBot\Services\DiscordInteractionService;
use Nwilging\LaravelDiscordBot\Services\DiscordInteractionWebhooksService;
use Nwilging\LaravelDiscordBot\Support\Interactions\Handlers\ApplicationCommandHandler;
use Nwilging\LaravelDiscordBot\Support\Interactions\Handlers\MessageComponentInteractionHandler;

class DiscordBotServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/discord.php', 'discord');
    }

    public function register()
    {
        Notification::resolved(function (ChannelManager $channelManager): void {
            $channelManager->extend('discord', function (): DiscordNotificationChannelContract {
                return $this->app->make(DiscordNotificationChannelContract::class);
            });
        });

        $this->app->bind(ClientInterface::class, Client::class);

        $this->app->bind(DiscordApiServiceContract::class, DiscordApiService::class);
        $this->app->when(DiscordApiService::class)->needs('$token')->give(function (): string {
            return $this->app->make(Config::class)->get('discord.token');
        });

        $this->app->when(DiscordApiService::class)->needs('$apiUrl')->give(function (): string {
            return $this->app->make(Config::class)->get('discord.api_url');
        });

        $this->app->bind(DiscordInteractionServiceContract::class, DiscordInteractionService::class);
        $this->app->when(DiscordInteractionService::class)->needs('$applicationId')->give(function (): string {
            return $this->app->make(Config::class)->get('discord.application_id');
        });

        $this->app->when(DiscordInteractionService::class)->needs('$publicKey')->give(function (): string {
            return $this->app->make(Config::class)->get('discord.public_key');
        });

        $this->app->when(MessageComponentInteractionHandler::class)->needs('$defaultBehavior')->give(function (): string {
            return $this->app->make(Config::class)->get('discord.interactions.component_interaction_default_behavior');
        });

        $this->app->when(ApplicationCommandHandler::class)->needs('$defaultBehavior')->give(function (): string {
            return $this->app->make(Config::class)->get('discord.interactions.component_interaction_default_behavior');
        });

        $this->app->bind(DiscordNotificationChannelContract::class, DiscordNotificationChannel::class);

        $this->app->bind(DiscordApplicationCommandServiceContract::class, DiscordApplicationCommandService::class);

        $this->app->when(DiscordApplicationCommandService::class)->needs('$token')->give(function (): string {
            return $this->app->make(Config::class)->get('discord.token');
        });

        $this->app->when(DiscordApplicationCommandService::class)->needs('$apiUrl')->give(function (): string {
            return $this->app->make(Config::class)->get('discord.api_url');
        });

        $this->app->when(DiscordApplicationCommandService::class)->needs('$applicationId')->give(function (): string {
            return $this->app->make(Config::class)->get('discord.application_id');
        });

        $this->app->bind(DiscordInteractionWebhooksServiceContract::class, DiscordInteractionWebhooksService::class);

        $this->app->when(DiscordInteractionWebhooksService::class)->needs('$token')->give(function (): string {
            return $this->app->make(Config::class)->get('discord.token');
        });

        $this->app->when(DiscordInteractionWebhooksService::class)->needs('$apiUrl')->give(function (): string {
            return $this->app->make(Config::class)->get('discord.api_url');
        });

        $this->app->when(DiscordInteractionWebhooksService::class)->needs('$applicationId')->give(function (): string {
            return $this->app->make(Config::class)->get('discord.application_id');
        });
    }
}
