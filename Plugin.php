<?php namespace Vdomah\Botman;

use System\Classes\PluginBase;
use Vdomah\Botman\Models\Settings;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Botman',
                'icon'        => 'icon-arrows',
                'description' => 'Botman settings',
                'class'       => Settings::class,
                'order'       => 0,
                'permissions' => ['vdomah.botman.access_settings'],
            ],
        ];
    }
}
