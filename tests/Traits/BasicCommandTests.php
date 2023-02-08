<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Traits;

use Nwilging\LaravelDiscordBot\Support\Command;

trait BasicCommandTests
{
    protected Command $command;

    protected int $expectedType;

    public function testCommandType()
    {
        $this->assertSame($this->expectedType, $this->command->getType());
    }
}
