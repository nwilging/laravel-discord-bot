<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBotTests\Unit\Services;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Mockery\MockInterface;
use Nwilging\LaravelDiscordBot\Services\DiscordInteractionService;
use Nwilging\LaravelDiscordBot\Support\Interactions\DiscordInteractionResponse;
use Nwilging\LaravelDiscordBot\Support\Interactions\Handlers\ApplicationCommandHandler;
use Nwilging\LaravelDiscordBot\Support\Interactions\Handlers\MessageComponentInteractionHandler;
use Nwilging\LaravelDiscordBot\Support\Interactions\Handlers\PingHandler;
use Nwilging\LaravelDiscordBot\Support\Interactions\InteractionHandler;
use Nwilging\LaravelDiscordBotTests\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class DiscordInteractionServiceTest extends TestCase
{
    protected string $publicKey;

    protected string $privateKey;

    protected string $applicationId = 'application-id';

    protected MockInterface $laravel;

    protected DiscordInteractionService $service;

    public function setUp(): void
    {
        parent::setUp();

        $keypair = sodium_crypto_sign_keypair();
        $this->publicKey = sodium_crypto_sign_publickey($keypair);
        $this->privateKey = sodium_crypto_sign_secretkey($keypair);

        $this->laravel = \Mockery::mock(Application::class);

        $this->service = new DiscordInteractionService($this->applicationId, bin2hex($this->publicKey), $this->laravel);
    }

    public function testHandleInteractionRequestThrows404WhenNoHandlerFound()
    {
        $timestamp = '12345';
        $body = 'test-body';
        $signature = bin2hex(sodium_crypto_sign_detached(sprintf('%s%s', $timestamp, $body), $this->privateKey));

        $expectedJson = [
            'type' => 999, // invalid type
        ];

        $request = \Mockery::mock(Request::class);
        $request->shouldAllowMockingMethod('all');

        $request->shouldReceive('json')->once()->andReturnSelf();
        $request->shouldReceive('all')->once()->andReturn($expectedJson);

        $request->shouldReceive('header')->once()->with('X-Signature-Ed25519')->andReturn($signature);
        $request->shouldReceive('header')->once()->with('X-Signature-Timestamp')->andReturn($timestamp);
        $request->shouldReceive('getContent')->once()->andReturn($body);

        $this->expectException(NotFoundHttpException::class);
        $this->service->handleInteractionRequest($request);
    }

    public function testHandleInteractionRequestThrows401WhenMissingRequiredData()
    {
        $request = \Mockery::mock(Request::class);
        $request->shouldAllowMockingMethod('all');

        $request->shouldReceive('header')->once()->with('X-Signature-Ed25519')->andReturnNull();
        $request->shouldReceive('header')->once()->with('X-Signature-Timestamp')->andReturnNull();
        $request->shouldReceive('getContent')->once()->andReturnNull();

        $this->expectException(UnauthorizedHttpException::class);
        $this->service->handleInteractionRequest($request);
    }

    public function testHandleInteractionRequestThrows401WhenSignatureVerificationFails()
    {
        $timestamp = '12345';
        $body = 'test-body';
        $signature = bin2hex(sodium_crypto_sign_detached(sprintf('%s%s', $timestamp, $body), $this->privateKey));

        $request = \Mockery::mock(Request::class);
        $request->shouldAllowMockingMethod('all');

        $request->shouldReceive('header')->once()->with('X-Signature-Ed25519')->andReturn($signature);
        $request->shouldReceive('header')->once()->with('X-Signature-Timestamp')->andReturn($timestamp);
        $request->shouldReceive('getContent')->once()->andReturn('something different');

        $this->expectException(UnauthorizedHttpException::class);
        $this->service->handleInteractionRequest($request);
    }

    public function testHandleInteractionRequestThrows401OnSodiumException()
    {
        $timestamp = '12345';
        $body = 'test-body';
        $signature = bin2hex(sodium_crypto_sign_detached(sprintf('%s%s', $timestamp, $body), $this->privateKey));

        $request = \Mockery::mock(Request::class);
        $request->shouldAllowMockingMethod('all');

        $request->shouldReceive('header')->once()->with('X-Signature-Ed25519')->andReturn($signature);
        $request->shouldReceive('header')->once()->with('X-Signature-Timestamp')->andReturn($timestamp);
        $request->shouldReceive('getContent')->once()->andReturn('something different');

        $this->expectException(UnauthorizedHttpException::class);

        $service = new DiscordInteractionService($this->applicationId, 'abc123', $this->laravel);
        $service->handleInteractionRequest($request);
    }

    /**
     * @dataProvider handlerDataProvider
     */
    public function testHandleInteractionBuildsAndHandlesRequest(int $type, string $expectedHandlerClass)
    {
        $timestamp = '12345';
        $body = 'test-body';
        $signature = bin2hex(sodium_crypto_sign_detached(sprintf('%s%s', $timestamp, $body), $this->privateKey));

        $expectedJson = [
            'type' => $type,
        ];

        $request = \Mockery::mock(Request::class);
        $request->shouldAllowMockingMethod('all');

        $request->shouldReceive('json')->once()->andReturnSelf();
        $request->shouldReceive('all')->once()->andReturn($expectedJson);

        $request->shouldReceive('header')->once()->with('X-Signature-Ed25519')->andReturn($signature);
        $request->shouldReceive('header')->once()->with('X-Signature-Timestamp')->andReturn($timestamp);
        $request->shouldReceive('getContent')->once()->andReturn($body);

        $expectedHandlerReturn = new DiscordInteractionResponse(0);

        $handlerMock = \Mockery::mock(InteractionHandler::class);
        $handlerMock->shouldReceive('handle')->once()->with($request)->andReturn($expectedHandlerReturn);

        $this->laravel->shouldReceive('make')->once()->with($expectedHandlerClass)->andReturn($handlerMock);

        $result = $this->service->handleInteractionRequest($request);
        $this->assertSame($expectedHandlerReturn, $result);
    }

    public function handlerDataProvider(): array
    {
        return [
            [1, PingHandler::class],
            [2, ApplicationCommandHandler::class],
            [3, MessageComponentInteractionHandler::class],
        ];
    }
}
