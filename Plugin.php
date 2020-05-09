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
                'label'       => 'vdomah.botman::lang.settings.name',
                'icon'        => 'icon-arrows',
                'description' => 'vdomah.botman::lang.settings.description',
                'class'       => Settings::class,
                'order'       => 500,
                'permissions' => ['vdomah.botman.access_settings'],
            ],
        ];
    }

    public function registerPermissions()
    {
        return [
            'vdomah.botman.access_settings' => [
                'tab' => 'vdomah.botman::lang.plugin.name',
                'label' => 'vdomah.botman::lang.permissions.access_settings'
            ],
        ];
    }
}
