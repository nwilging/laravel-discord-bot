<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Support\Internal\Commands;

use Illuminate\Contracts\Foundation\Application;
use Mockery\MockInterface;
use Nwilging\LaravelDiscordBot\Contracts\Support\Internal\Commands\CommandContract;
use Nwilging\LaravelDiscordBot\Support\Command;
use Nwilging\LaravelDiscordBot\Support\Internal\Commands\CommandManager;
use Nwilging\LaravelDiscordBotTests\TestCase;

class CommandManagerTest extends TestCase
{
    protected MockInterface $laravel;

    protected CommandManager $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->laravel = \Mockery::mock(Application::class);
        $this->service = new CommandManager($this->laravel);
    }

    public function testRegisterValidationFailsForMissingSignatureMethod()
    {
        $class = new class {
        };

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(sprintf('%s is not a valid command class: missing method `signature`', get_class($class)));

        $this->service->register(get_class($class));
    }

    public function testRegisterValidationFailsForMissingDescriptionMethod()
    {
        $class = new class {
            public static function signature(): string
            {
                return 'test';
            }
        };

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(sprintf('%s is not a valid command class: missing method `description`', get_class($class)));

        $this->service->register(get_class($class));
    }

    public function testRegister()
    {
        $class1 = new class {
            public static function signature(): string
            {
                return 'test';
            }

            public static function description(): string
            {
                return 'test';
            }

            public static function type(): int
            {
                return Command::TYPE_CHAT_INPUT;
            }
        };

        $class2 = new class {
            public static function signature(): string
            {
                return 'test2';
            }

            public static function description(): string
            {
                return 'test';
            }

            public static function type(): int
            {
                return Command::TYPE_USER;
            }
        };

        $class3 = new class {
            public static function signature(): string
            {
                return 'test3';
            }

            public static function description(): string
            {
                return 'test';
            }

            public static function type(): int
            {
                return Command::TYPE_MESSAGE;
            }
        };

        $this->service->register(get_class($class1));
        $this->service->register(get_class($class2));
        $this->service->register(get_class($class3));

        $this->assertEquals([
            Command::TYPE_CHAT_INPUT => [
                'test' => get_class($class1),
            ],
            Command::TYPE_USER => [
                'test2' => get_class($class2),
            ],
            Command::TYPE_MESSAGE => [
                'test3' => get_class($class3),
            ],
        ], $this->service->all());
    }

    public function testRegisterAllowsDuplicateSignaturesUnderDifferentTypes()
    {
        $class1 = new class {
            public static function signature(): string
            {
                return 'test';
            }

            public static function description(): string
            {
                return 'test';
            }

            public static function type(): int
            {
                return Command::TYPE_CHAT_INPUT;
            }
        };

        $class2 = new class {
            public static function signature(): string
            {
                return 'test';
            }

            public static function description(): string
            {
                return 'test';
            }

            public static function type(): int
            {
                return Command::TYPE_USER;
            }
        };

        $class3 = new class {
            public static function signature(): string
            {
                return 'test';
            }

            public static function description(): string
            {
                return 'test';
            }

            public static function type(): int
            {
                return Command::TYPE_MESSAGE;
            }
        };

        $this->service->register(get_class($class1));
        $this->service->register(get_class($class2));
        $this->service->register(get_class($class3));

        $this->assertEquals([
            Command::TYPE_CHAT_INPUT => [
                'test' => get_class($class1),
            ],
            Command::TYPE_USER => [
                'test' => get_class($class2),
            ],
            Command::TYPE_MESSAGE => [
                'test' => get_class($class3),
            ],
        ], $this->service->all());
    }

    public function testGet()
    {
        $class1 = new class {
            public static function signature(): string
            {
                return 'test';
            }

            public static function description(): string
            {
                return 'test';
            }

            public static function type(): int
            {
                return Command::TYPE_CHAT_INPUT;
            }
        };

        $class2 = new class {
            public static function signature(): string
            {
                return 'test';
            }

            public static function description(): string
            {
                return 'test';
            }

            public static function type(): int
            {
                return Command::TYPE_USER;
            }
        };

        $class3 = new class {
            public static function signature(): string
            {
                return 'test';
            }

            public static function description(): string
            {
                return 'test';
            }

            public static function type(): int
            {
                return Command::TYPE_MESSAGE;
            }
        };

        $this->service->register(get_class($class1));
        $this->service->register(get_class($class2));
        $this->service->register(get_class($class3));

        $command1 = \Mockery::mock(CommandContract::class);
        $command2 = \Mockery::mock(CommandContract::class);
        $command3 = \Mockery::mock(CommandContract::class);

        $this->laravel->shouldReceive('make')->with(get_class($class1))->andReturn($command1);
        $this->laravel->shouldReceive('make')->with(get_class($class2))->andReturn($command2);
        $this->laravel->shouldReceive('make')->with(get_class($class3))->andReturn($command3);

        $result1 = $this->service->get(Command::TYPE_CHAT_INPUT, 'test');
        $result2 = $this->service->get(Command::TYPE_USER, 'test');
        $result3 = $this->service->get(Command::TYPE_MESSAGE, 'test');

        $this->assertSame($command1, $result1);
        $this->assertSame($command2, $result2);
        $this->assertSame($command3, $result3);
    }

    public function testGetThrowsExceptionForInvalidCommand()
    {
        $class1 = new class {
            public static function signature(): string
            {
                return 'test';
            }

            public static function description(): string
            {
                return 'test';
            }

            public static function type(): int
            {
                return Command::TYPE_CHAT_INPUT;
            }
        };

        $this->service->register(get_class($class1));

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid command: test');

        $this->service->get(Command::TYPE_USER, 'test');
    }
}
