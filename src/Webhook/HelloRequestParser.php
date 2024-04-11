<?php

namespace App\Webhook;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RemoteEvent\RemoteEvent;
use Symfony\Component\Webhook\Exception\RejectWebhookException;
use Symfony\Component\Webhook\Client\RequestParserInterface;

class HelloRequestParser implements RequestParserInterface
{
    public function parse(Request $request, string $secret): ?RemoteEvent
    {
        // Validate the request from Stripe
        if (!$this->isValidRequest($request)) {
            throw new RejectWebhookException('Invalid hello request.');
        }
        // Convert the request into a RemoteEvent object
        $data = $request->getContent();
        $eventData = json_decode($data, true) ?? [];
        $eventData['hello'] ??= 'world';
        $name = 'hello';
        $id = bin2hex(random_bytes(16));
        $remoteEvent = new RemoteEvent($name, $id, $eventData);
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
        return new Response('', 202);
    }

    public function createRejectedResponse(string $reason): Response
    {
        return new Response($reason, 406);
    }
}
