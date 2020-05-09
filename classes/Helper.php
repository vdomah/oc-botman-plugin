<?php namespace Vdomah\Botman\Classes;

use BotMan\BotMan\Drivers\DriverManager;
use October\Rain\Support\Traits\Singleton;
use Vdomah\Botman\Models\Settings;

class Helper
{
    use Singleton;

    const EVENT_LOAD_DRIVER = 'vdomah.botman.load_driver';
    const EVENT_BEFORE_LISTEN = 'vdomah.botman.before_listen';

    const DRIVER_DEFAULT = 'BotMan\Drivers\Telegram\TelegramDriver';

    public $config = [];

    /**
     * Initialize the singleton free from constructor parameters.
     */
    protected function init()
    {
        $this->makeConfig();
    }

    public function makeConfig()
    {
        $this->config = [
            'config' => [
                'conversation_cache_time' => Settings::get('conversation_cache_time', 60),
            ],
        ];

        foreach (Settings::get('drivers', []) as $arDriver) {
            $arSettings = [];

            foreach ($arDriver['settings'] as $arSetting) {
                $arSettings[$arSetting['field']] = $arSetting['value'];
            }

            $this->config[$arDriver['code']] = $arSettings;
        }
    }

    public function loadDriverDefault()
    {
        $arDrivers = DriverManager::getAvailableDrivers();

        if (empty($arDrivers) && class_exists(self::DRIVER_DEFAULT)) {
            DriverManager::loadDriver(self::DRIVER_DEFAULT);
        }
    }
}