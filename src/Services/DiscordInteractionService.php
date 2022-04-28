<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Services;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordInteractionServiceContract;
use Nwilging\LaravelDiscordBot\Support\Interactions\DiscordInteractionResponse;
use Nwilging\LaravelDiscordBot\Support\Interactions\Handlers\ApplicationCommandHandler;
use Nwilging\LaravelDiscordBot\Support\Interactions\Handlers\MessageComponentInteractionHandler;
use Nwilging\LaravelDiscordBot\Support\Interactions\Handlers\PingHandler;
use Nwilging\LaravelDiscordBot\Support\Interactions\InteractionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class DiscordInteractionService implements DiscordInteractionServiceContract
{
    protected string $applicationId;

    protected string $publicKey;

    protected Application $laravel;

    protected array $interactionHandlers = [
        InteractionHandler::REQUEST_TYPE_PING => PingHandler::class,
        InteractionHandler::REQUEST_TYPE_APPLICATION_COMMAND => ApplicationCommandHandler::class,
        InteractionHandler::REQUEST_TYPE_MESSAGE_COMPONENT => MessageComponentInteractionHandler::class,
    ];

    public function __construct(string $applicationId, string $publicKey, Application $laravel)
    {
        $this->applicationId = $applicationId;
        $this->publicKey = $publicKey;
        $this->laravel = $laravel;
    }

    public function handleInteractionRequest(Request $request): DiscordInteractionResponse
    {
        $this->validate($request);
        $json = $request->json()->all();

        $handlerClass = $this->interactionHandlers[$json['type']] ?? null;
        if (!$handlerClass) {
            throw new NotFoundHttpException();
        }

        $handler = $this->laravel->make($handlerClass);
        return $handler->handle($request);
    }

    protected function validate(Request $request): void
    {
        $signature = $request->header('X-Signature-Ed25519');
        $timestamp = $request->header('X-Signature-Timestamp');
        $body = $request->getContent();

        if (!$signature || !$timestamp || !$body) {
            throw new UnauthorizedHttpException('invalid request signature');
        }

        $data = sprintf('%s%s', $timestamp, $body);
        try {
            $verified = sodium_crypto_sign_verify_detached(hex2bin($signature), $data, hex2bin($this->publicKey));
        } catch (\SodiumException $exception) {
            throw new UnauthorizedHttpException('invalid request signature');
        }

        if (!$verified) {
            throw new UnauthorizedHttpException('invalid request signature');
        }
    }
}
