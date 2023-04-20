# Notification Channel

This package supports sending notifications via [Laravel Notifications](https://laravel.com/docs/10.x/notifications).

Your notification class must:
* Implement the interface: `Nwilging\LaravelDiscordBot\Contracts\Notifications\DiscordNotificationContract`
* Include the method: `toDiscord(): array`

You may choose to send either a plain text message or rich text message.

---

## Sending Plain Text message

A plain text message is one without rich text components, including embeds or interactive
components. Plain text messages support emojis and markdown.

```phpt
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Nwilging\LaravelDiscordBot\Contracts\Notifications\DiscordNotificationContract;
use Nwilging\LaravelDiscordBot\Support\Builder\ComponentBuilder;
use Nwilging\LaravelDiscordBot\Support\Builder\EmbedBuilder;

class TestNotification extends Notification implements DiscordNotificationContract
{
    use Queueable;

    public function via($notifiable)
    {
        return ['discord'];
    }

    public function toDiscord($notifiable): array
    {
        return [
            'contentType' => 'plain',
            'channelId' => 'channel ID',
            'message' => 'message content',
        ];
    }
}
```

## Sending Rich Text Message

A rich text message is a message that contains embeds and/or components. This may
include images, videos, interactive components, etc.

```phpt
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Nwilging\LaravelDiscordBot\Contracts\Notifications\DiscordNotificationContract;
use Nwilging\LaravelDiscordBot\Support\Builder\ComponentBuilder;
use Nwilging\LaravelDiscordBot\Support\Builder\EmbedBuilder;

class TestNotification extends Notification implements DiscordNotificationContract
{
    use Queueable;

    public function via($notifiable)
    {
        return ['discord'];
    }

    public function toDiscord($notifiable): array
    {
        $embedBuilder = new EmbedBuilder();
        $embedBuilder->addAuthor('Me!');

        $componentBuilder = new ComponentBuilder();
        $componentBuilder->addActionButton('My Button', 'customId');

        return [
            'contentType' => 'rich',
            'channelId' => 'channel id',
            'embeds' => $embedBuilder->getEmbeds(),
            'components' => [
                $componentBuilder->getActionRow(),
            ],
        ];
    }
}
```

### How to get a `channelId`

[How to find Discord IDs](https://www.remote.tools/remote-work/how-to-find-discord-id#how-to)

You must specify the actual ID of the channel when sending messages to the Discord API. This can be done directly in
the Discord client application by enabling developer tools.
