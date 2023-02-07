# trainee-telegram-bot-client

Telegram bot client example

# Description

This project can be used as an example of creating packages and installing them using composer.

It can be useful for those who are learning PHP and related technologies, or for those who are teaching students.

# Example

Add current package:

```
composer require pashkevich-s-d/trainee-telegram-bot-client
```

Then:
```
use \PashkevichSD\TraineeTelegramBotClient\Service\TelegramBotClient;
use \PashkevichSD\TraineeTelegramBotClient\Model\Request\Message;

$telegramBotClient = new TelegramBotClient('YourTelegramBotToken');
```

To be able to get updates:

```
$telegramBotClient->getUpdates();
```

To be able to send message:
```
telegramBotClient->sendMessage((new Message())->setChatId($chatId)->setText($message));
```
