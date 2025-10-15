<?php

namespace Xaraya\SymfonyApp\Webhook;

use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RemoteEvent\RemoteEvent;
use Symfony\Component\Webhook\Exception\RejectWebhookException;
use Symfony\Component\Webhook\Client\RequestParserInterface;

class HelloRequestParser implements RequestParserInterface
{
    private RemoteEvent $echoEvent;

    public function parse(Request $request, string $secret): ?RemoteEvent
    {
        // Validate the request from Stripe
        if (!$this->isValidRequest($request)) {
            throw new RejectWebhookException('Invalid hello request.');
        }
        // Convert the request into a RemoteEvent object
        $type = 'hello';
        $id = bin2hex(random_bytes(16));
        $data = $request->getContent();
        if (in_array($request->getMethod(), ['GET', 'HEAD']) && empty($data)) {
            $eventData = [];
        } else {
            try {
                $eventData = json_decode($data, true, 10, JSON_THROW_ON_ERROR) ?? [];
            } catch (JsonException $e) {
                $eventData = [
                    'payload_size' => strlen($data),
                    'json_error' => $e->getMessage(),
                ];
            }
        }
        $name = $request->get('name', 'symfony');
        $eventData[$type] ??= rawurlencode($name);
        $eventData['method'] ??= $request->getMethod();
        $remoteEvent = new RemoteEvent($type, $id, $eventData);
        // we could even echo it back in response...
        if (!empty($_ENV['APP_WEBHOOK_ECHO'])) {
            $this->echoEvent = $remoteEvent;
        }
        return $remoteEvent;
    }

    private function isValidRequest(Request $request): bool
    {
        // Logic for verifying the request
        // ...
        return true;
    }

    public function createSuccessfulResponse(): Response
    {
        // we could even echo it back in response...
        if (!empty($_ENV['APP_WEBHOOK_ECHO'])) {
            $name = $this->echoEvent->getName();
            $id = $this->echoEvent->getId();
            $payload = $this->echoEvent->getPayload();
            $message = "Received Event $name ($id):\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n";
            return new Response($message, 200, ['Content-Type' => 'text/plain']);
        }
        return new Response('', 202);
    }

    public function createRejectedResponse(string $reason): Response
    {
        return new Response($reason, 406);
    }
}
