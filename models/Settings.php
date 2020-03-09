<?php namespace Vdomah\Botman\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'vdomah_botman_settings';

    public $settingsFields = 'fields.yaml';
}