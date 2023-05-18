# TransferGo Homework task for Sergej Kurakin

Not sure what you mean by "service", is it an internal web/micro service or is it just a Symfony service.
This is why I decided to do a Command, based on "symfony/messenger". This allows to integrate it into controller 
(you can find very dummy version) or use from anywhere in the app using MessageBusInterface.

I store every notification in database, because we need a way to track them and to resend, if sending fails.
This approach will allow us to use background task to send them. Retrying ove few sending providers, 
that include network communication should be (if not must) in background task.

I use very simplified command line command to run as cron (300 messages per hour), reading 10 messages, so it should run every 2 minutes.
In ideal situation I would move that limit into configuration.

Now, the NotificationPublisher/Infrastructure or abstraction over notification systems.

I haven't registered on any of the systems to try them. I see no real point to do so.
I looked over libraries and example code they provide to do initial integration, so, that part looks a bit "bad".
In any case, any credentials would be placed into "security vault" (platform implementation details, simple case: ejson) and provided via environment variables.
Every third party library would be initiated using Symfony config and provided as injection into abstraction.

I created EmailSender, PushNotificationSender, SMSSender as interfaces for future concrete implementation of corresponding providers.
EmailMessage, PushNotificationMessage, SMSMessage will provide only needed information to EmailSender, PushNotificationSender, SMSSender.
No other dependency or object or information would leak into concrete senders.
Every Sender is responsible just for sending provided minimal information through third party library.
For my quick experiments I've added Echo*Sender for each type of senders.

<any>SenderWrapper is just an abstraction to hide details how Notification Entity and User Identity converted 
into proper value object (EmailMessage, PushNotificationMessage, SMSMessage) and then passed to Sender.
This is how I separate data conversion concern from sending.

NotificationDispatcher just loops over senders and marks sent notifications as sent. My bad, have no quick idea how handle it with database.
Maybe something like "scheduled at" would help with this.

Now, config of senders. It's setup  in config/services.yaml List of classes:

```yaml
app.notification_senders:
    - 'App\NotificationPublisher\Infrastructure\Push\EchoPushNotificationSender'
    - 'App\NotificationPublisher\Infrastructure\SMS\EchoSMSSender'
    - 'App\NotificationPublisher\Infrastructure\Email\EchoEmailSender'
```
with real provided examples they would be:
```yaml
app.notification_senders:
    - 'App\NotificationPublisher\Infrastructure\Push\PushySender'
    - 'App\NotificationPublisher\Infrastructure\SMS\TwilioSender'
    - 'App\NotificationPublisher\Infrastructure\Email\AWSSendEmailSender'
```
Proper setup for every service should be done in Service Container and credentials in environment.

config is processed in NotificationDispatcherFactory, every service is requested from Container.
I know, a bit anti-pattern to inject Container into anything, but this is a Factory.
I don't like my if/elseif/else for wrapper selection, but this is solution that at least works for now.

As minimal toolset to improve code I used `phpstan` (static code analysis) and `php-cs-fixer` to keep all code under same coding style.
Default configs will be OK for sake of this example.

# Symfony Docker

A [Docker](https://www.docker.com/)-based installer and runtime for the [Symfony](https://symfony.com) web framework, with full [HTTP/2](https://symfony.com/doc/current/weblink.html), HTTP/3 and HTTPS support.

![CI](https://github.com/dunglas/symfony-docker/workflows/CI/badge.svg)

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up` (the logs will be displayed in the current shell)
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Features

* Production, development and CI ready
* [Installation of extra Docker Compose services](docs/extra-services.md) with Symfony Flex
* Automatic HTTPS (in dev and in prod!)
* HTTP/2, HTTP/3 and [Preload](https://symfony.com/doc/current/web_link.html) support
* Built-in [Mercure](https://symfony.com/doc/current/mercure.html) hub
* [Vulcain](https://vulcain.rocks) support
* Native [XDebug](docs/xdebug.md) integration
* Just 2 services (PHP FPM and Caddy server)
* Super-readable configuration

**Enjoy!**

## Docs

1. [Build options](docs/build.md)
2. [Using Symfony Docker with an existing project](docs/existing-project.md)
3. [Support for extra services](docs/extra-services.md)
4. [Deploying in production](docs/production.md)
5. [Debugging with Xdebug](docs/xdebug.md)
6. [TLS Certificates](docs/tls.md)
7. [Using a Makefile](docs/makefile.md)
8. [Troubleshooting](docs/troubleshooting.md)

## License

Symfony Docker is available under the MIT License.

## Credits

Created by [Kévin Dunglas](https://dunglas.fr), co-maintained by [Maxime Helias](https://twitter.com/maxhelias) and sponsored by [Les-Tilleuls.coop](https://les-tilleuls.coop).
