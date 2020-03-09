<?php
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use Vdomah\Botman\Models\Settings;

Route::match(['get', 'post'], '/botman', function () {
    $config = [
        // Your driver-specific configuration
        "telegram" => [
            "token" => Settings::get('telegram_bot_key'),
        ],
        'config' => [
            'conversation_cache_time' => 30,
        ],
    ];
// Load the driver(s) you want to use
    Event::fire('vdomah.botman.load_driver');

// Create an instance
    $cache = new LaravelCache;
    $botman = BotManFactory::create($config, $cache);

// Give the bot something to listen for.
    Event::fire('vdomah.botman.before_listen', [$botman]);

// Start listening
    $botman->listen();
});