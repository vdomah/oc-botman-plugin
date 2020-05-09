<?php return [
    'plugin' => [
        'name' => 'Botman',
        'description' => 'Messenger agnostic bot framework integration with OctoberCMS',
    ],
    'fields' => [
        'drivers' => [
            'label' => 'Drivers',
            'code' => [
                'label' => 'Code',
                'comment' => 'This code should correspond to config key of driver. For existing drivers check the docs to get the right code. For Telegram use "telegram": https://botman.io/2.0/driver-telegram#installation-setup. For custom driver use your own key defined in driver class',
            ],
            'settings' => [
                'label' => 'Settings',
                'field' => 'Field',
                'value' => 'Value',
            ],
        ],
        'conversation_cache_time' => [
            'label' => 'Conversation cache time',
            'comment' => 'Double check what basic time dimension your Laravel version uses, seconds or milliseconds and set your cache time accordingly',
        ],
    ],
    'settings' => [
        'name' => 'Botman',
        'description' => 'Botman bots configuration',
    ],
    'permissions' => [
        'access_settings' => 'Botman settings access',
    ],
];