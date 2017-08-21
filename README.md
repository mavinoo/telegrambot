# Telegram Notifications Channel Plus for Laravel 5.3 [WIP]

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/telegram.svg?style=flat-square)](https://packagist.org/packages/mavinoo/telegrambot)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/mavinoo/telegrambot.svg?style=flat-square)](https://packagist.org/packages/mavinoo/telegrambot)

This package makes it easy to send Telegram notification using [Telegram Bot API](https://core.telegram.org/bots) with Laravel 5.3.

## Contents

- [Installation](#installation)
	- [Setting up your Telegram bot](#setting-up-your-telegram-bot)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Alternatives](#alternatives)
- [License](#license)

## Installation

You can install the package via composer:
1: Change composer.json

``` bash
    "require": {
        "mavinoo/telegrambot": "dev-master"
    },
    "repositories": [
	{
	  "url": "https://github.com/mavinoo/telegrambot.git",
	  "type": "git",
	  "reference":"master"
	}
    ],
```

2: command line 
```
composer update
```



You must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    NotificationChannelsPlus\Telegrambot\TelegrambotServiceProvider::class,
],
```

## Setting up your Telegram Bot

Talk to [@BotFather](https://core.telegram.org/bots#6-botfather) and generate a Bot API Token.

Then, configure your Telegram Bot API Token:

```php
// config/services.php
...
'telegram-bot-api' => [
    'token' => env('TELEGRAM_BOT_TOKEN', 'YOUR BOT TOKEN HERE')
],
...
```

## Usage sendMessage

You can now use the channel in your `via()` method inside the Notification class.

``` php
use NotificationChannelsPlus\Telegrambot\TelegramChannel;
use NotificationChannelsPlus\Telegrambot\TelegramMessage;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification
{
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $url = url('/invoice/' . $this->invoice->id);

        return TelegramMessage::create()
            ->to($this->user->telegram_user_id) // Optional.
            ->content("*HELLO!* \n One of your invoices has been paid!") // Markdown supported.
            ->button('View Invoice', $url); // Inline Button
    }
}
```

## Usage sendPhoto

You can now use the channel in your `via()` method inside the Notification class.

``` php
use NotificationChannelsPlus\Telegrambot\TelegramChannel;
use NotificationChannelsPlus\Telegrambot\TelegramMessage;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification
{
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $url = url('/invoice/' . $this->invoice->id);

        return TelegramMessage::create()
            ->to($this->user->telegram_user_id) // Optional.
            ->sendPhoto([
                'caption'   =>  'Hello Mohammad',
                'photo'     =>  'http://www.ilovegenerator.com/large/i-love-mohamed-132309992962.png',
            ]) // Markdown supported.
            ->button('View Invoice', $url); // Inline Button
    }
}
```

### Available Message methods

- `to($chatId)`: (integer) Recipient's chat id.
- `content('')`: (string) Notification message, supports markdown. For more information on supported markdown styles, check out these [docs](https://telegram-bot-sdk.readme.io/docs/sendmessage#section-markdown-style).
- `button($text, $url)`: (string) Adds an inline "Call to Action" button. You can add as many as you want and they'll be placed 2 in a row.
- `options([])`: (array) Allows you to add additional or override `sendMessage` payload (A Telegram Bot API method used to send message internally). For more information on supported parameters, check out these [docs](https://telegram-bot-sdk.readme.io/docs/sendmessage).


## Alternatives

For advance usage, please consider using [telegram-bot-sdk](https://github.com/irazasyed/telegram-bot-sdk) instead.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
