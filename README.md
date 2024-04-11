# Basic Symfony Webhook application

This is a basic [Symfony Framework](https://symfony.com/doc/current/setup.html) application with a [Webhook](https://symfony.com/doc/current/webhook.html) request parser and matching [Remote Event](https://symfony.com/components/RemoteEvent) webhook listener

To handle /webhook/`hello` requests:
1. src/Webhook/: `hello` [request parser](./src/Webhook/HelloRequestParser.php)
2. src/RemoteEvent/: `hello` [webhook listener](./src/RemoteEvent/HelloWebhookListener.php)
3. config/packages/framework.yaml: `hello` [webhook routing](./config/packages/framework.yaml)

You could use one of the Symfony [Mailer](https://symfony.com/doc/current/mailer.html) or [Notifier](https://symfony.com/doc/current/notifier.html) packages and bundles as consumer, switch to [async/queued messages](https://symfony.com/doc/current/messenger.html#transports-async-queued-messages) with retries etc.
