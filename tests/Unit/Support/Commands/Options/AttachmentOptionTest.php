<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Commands\Options;

use Nwilging\LaravelDiscordBot\Support\Commands\CommandOption;
use Nwilging\LaravelDiscordBot\Support\Commands\Options\AttachmentOption;
use Nwilging\LaravelDiscordBotTests\TestCase;
use Nwilging\LaravelDiscordBotTests\Traits\BasicCommandOptionTests;

class AttachmentOptionTest extends TestCase
{
    use BasicCommandOptionTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->expectedType = CommandOption::TYPE_ATTACHMENT;
        $this->option = new AttachmentOption('option', 'desc');
    }
}
