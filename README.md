### Listening to events

````
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use BotMan\Drivers\Telegram\TelegramPhotoDriver;
use Vdomah\ElsePlugin\Conversations\DefaultConversation;

public function boot()
{
// You need to load required drivers, telegram in this case
    Event::listen('vdomah.botman.load_driver', function () {
        DriverManager::loadDriver(TelegramDriver::class);
        DriverManager::loadDriver(TelegramPhotoDriver::class);
    });

    // than you create your listeners to init a conversation.
    Event::listen('vdomah.botman.before_listen', function ($botman) {
        $botman->hears('hello|/start', function (BotMan $bot) {
            $bot->startConversation(new DefaultConversation());
        });
    });
}
````

### Conversations
Conversation is a class that you create in your plugin. Please check BotMan's docs: https://botman.io/2.0/conversations