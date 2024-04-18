<?php

namespace Xaraya\SymfonyApp\RemoteEvent;

use Symfony\Component\RemoteEvent\Attribute\AsRemoteEventConsumer;
use Symfony\Component\RemoteEvent\Consumer\ConsumerInterface;
use Symfony\Component\RemoteEvent\RemoteEvent;

#[AsRemoteEventConsumer('hello-symfony')]
class HelloWebhookConsumer implements ConsumerInterface
{
    public function consume(RemoteEvent $event): void
    {
        // @todo do something with this event
        $name = $event->getName();
        $id = $event->getId();
        $payload = $event->getPayload();
        // with the default (sync) messagebus, we could even echo it back...
        if (!empty($_ENV['APP_WEBHOOK_ECHO'])) {
            $message = "Consumed Event $name ($id):\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n";
            echo $message;
        }
    }
}
