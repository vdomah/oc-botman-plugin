<?php namespace Vdomah\Botman\Classes;

use Exception;
use Event;
use Lang;
use BotMan\BotMan\Drivers\DriverManager;
use Illuminate\Support\Collection;
use October\Rain\Support\Traits\Singleton;
use Vdomah\Botman\Models\Settings;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class Helper
{
    use Singleton;

    const EVENT_LOAD_DRIVER = 'vdomah.botman.load_driver';
    const EVENT_BEFORE_LISTEN = 'vdomah.botman.before_listen';
    const EVENT_FALLBACK = 'vdomah.botman.fallback';
    const EVENT_AFTER_CONFIG_READY = 'vdomah.botman.after_config_ready';

    const DRIVER_DEFAULT = 'BotMan\Drivers\Telegram\TelegramDriver';

    const VALUE_BACK = '/back';

    public $config = [];

    /**
     * Initialize the singleton free from constructor parameters.
     */
    protected function init()
    {
        $this->makeConfig();
    }

    /**
     * Make config array from backend settings and event listeners
     */
    public function makeConfig()
    {
        $this->config = [
            'config' => [
                'conversation_cache_time' => Settings::get('conversation_cache_time') ?: 60,
            ],
        ];

        foreach (Settings::get('drivers', []) as $arDriver) {
            $arSettings = [];

            foreach ($arDriver['settings'] as $arSetting) {
                $arSettings[$arSetting['field']] = $arSetting['value'];
            }

            $this->config[$arDriver['code']] = $arSettings;
        }

        $arResult = Event::fire(Helper::EVENT_AFTER_CONFIG_READY, [$this->config]);

        if (is_array($arResult) && isset($arResult[0]) && is_array($arResult[0])) {
            $this->config = $arResult[0];
        }
    }

    /**
     * Load default driver if no drivers were loaded before.
     * @TODO: remove after BotmanTelegram plugin added to marketplace
     */
    public function loadDriverDefault()
    {
        $arDrivers = DriverManager::getAvailableDrivers();

        if (empty($arDrivers) && class_exists(self::DRIVER_DEFAULT)) {
            DriverManager::loadDriver(self::DRIVER_DEFAULT);
        }
    }

    /**
     * Get array of Button objects
     * @param array || Collection $arData
     * @param bool $bWithBack
     * @return array
     */
    public function getButtons($arData = [], $bWithBack = true)
    {
        if (!is_array($arData) && !($arData instanceof Collection)) {
            throw new Exception('Argument 1 should be of type array or Collection');
        }
        if ($arData instanceof Collection) {
            $arData = $arData->toArray();
        }

        $arButtons = [];

        foreach ($arData as $sValue=>$mName) {
            if (is_array($mName) && isset($mName['label'])) {
                $sName = $mName['label'];
            } elseif (is_array($mName) && isset($mName['name'])) {
                $sName = $mName['name'];
            } else {
                $sName = $mName;
            }

            $arButtons[] = Button::create($sName)->value($sValue);
        }

        if ($bWithBack) {
            if (!isset($this->config['lang'])) {
                $this->config['lang'] = [];
            }
            if (!isset($this->config['lang']['back'])) {
                $this->config['lang']['back'] = Lang::get('vdomah.botman::lang.value.back');
            }

            $arButtons[] = Button::create($this->config['lang']['back'])->value(self::VALUE_BACK);
        }

        return $arButtons;
    }
}