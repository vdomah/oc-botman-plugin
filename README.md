### Listening to events

You need to create your own plugin to listen to BotMan's events and write your conversation classes.

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

    // than you create your listeners to hear and reply to a message or init a conversation.
    Event::listen('vdomah.botman.before_listen', function ($botman) {
        // https://botman.io/2.0/receiving
        $botman->hears('My First Message', function ($bot) {
            $bot->reply('Your First Response');
        });
        
        // https://botman.io/2.0/conversations
        $botman->hears('hello|/start', function (BotMan $bot) {
            $bot->startConversation(new DefaultConversation());
        });
    });
}
````

### Conversations
Conversation is a class that you create in your plugin. Please check BotMan's docs: https://botman.io/2.0/conversations