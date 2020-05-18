<?php
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use Vdomah\Botman\Classes\Helper;

Route::post('/botman', function () {
    // Listen to event to load driver(s) you want to use.
    // DriverManager::loadDriver(TelegramDriver::class);
    Event::fire(Helper::EVENT_LOAD_DRIVER);

    // load Telegram driver if no drivers added before and botman/telegram-driver is installed
    Helper::instance()->loadDriverDefault();

    // Create an instance
    $obBotman = BotManFactory::create(Helper::instance()->config, new LaravelCache);

    // Give bot something to listen for.
    Event::fire(Helper::EVENT_BEFORE_LISTEN, [$obBotman]);

    // Add fallback listener
    $obBotman->fallback(function($obBotman) {
        Event::fire(Helper::EVENT_FALLBACK, [$obBotman]);
    });

    // Start listening
    $obBotman->listen();
});