# Basic Symfony Webhook application

This is a basic [Symfony Framework](https://symfony.com/doc/current/setup.html) application with a [Webhook](https://symfony.com/doc/current/webhook.html) request parser and matching [Remote Event](https://symfony.com/components/RemoteEvent) webhook listener

Note: the **namespace** was changed from `App\` to `Xaraya\SymfonyApp\` to avoid conflicts on loading with third party frameworks

To handle `/webhook/hello-symfony` requests:
1. src/Webhook/: `hello-symfony` [request parser](./src/Webhook/HelloRequestParser.php)
2. src/RemoteEvent/: `hello-symfony` [webhook consumer](./src/RemoteEvent/HelloWebhookConsumer.php)
3. config/packages/framework.yaml: `hello-symfony` [webhook routing](./config/packages/framework.yaml)

You could use one of the Symfony [Mailer](https://symfony.com/doc/current/mailer.html) or [Notifier](https://symfony.com/doc/current/notifier.html) packages and bundles as consumer, switch to [async/queued messages](https://symfony.com/doc/current/messenger.html#transports-async-queued-messages) with retries etc.

## Adding webhooks

Use Symfony Maker to create new webhooks:

```console
$ bin/console make:webhook github
 created: src/Webhook/GithubRequestParser.php
 created: src/RemoteEvent/GithubWebhookConsumer.php
 updated: config/packages/webhook.yaml

 
  Success!
```
