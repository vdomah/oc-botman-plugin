<?php return [
    'plugin' => [
        'name' => 'Botman',
        'description' => 'Messenger agnostic bot framework integration with OctoberCMS',
    ],
    'fields' => [
        'drivers' => [
            'label' => 'Drivers',
            'code' => 'Code',
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