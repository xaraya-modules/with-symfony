<?php

namespace App\RemoteEvent;

use Symfony\Component\RemoteEvent\Attribute\AsRemoteEventConsumer;
use Symfony\Component\RemoteEvent\Consumer\ConsumerInterface;
use Symfony\Component\RemoteEvent\RemoteEvent;
use Symfony\Component\HttpFoundation\Response;

#[AsRemoteEventConsumer('hello')]
class HelloWebhookListener implements ConsumerInterface
{
    public function consume(RemoteEvent $event): void
    {
        // @todo do something with this event
        $name = $event->getName();
        $id = $event->getId();
        $payload = $event->getPayload();
        // with the default (sync) messagebus, we could even echo it back...
        //$message = "Event $name ($id):\n" . json_encode($payload, JSON_PRETTY_PRINT);
        //$response = new Response($message, 200, ['Content-Type' => 'text/plain']);
        //$response->send();
    }
}
