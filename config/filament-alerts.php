<?php

return [
    'types' => [
        [
            "name" => "Alert",
            "id" => "alert",
            "color" => "#fff",
            "icon" => "bx bxs-user"
        ],
        [
            "name" => "Info",
            "id" => "info",
            "color" => "#fff",
            "icon" => "bx bxs-user"
        ],
        [
            "name" => "Danger",
            "id" => "danger",
            "color" => "#fff",
            "icon" => "bx bxs-user"
        ],
        [
            "name" => "Success",
            "id" => "success",
            "color" => "#fff",
            "icon" => "bx bxs-user"
        ],
        [
            "name" => "Warring",
            "id" => "warring",
            "color" => "#fff",
            "icon" => "bx bxs-user"
        ],
    ],

    'provider' => "database",

    'models' => [
        \App\Models\User::class => "Admins",
    ],

    'providers' => [
        [
            "name" =>'Database',
            "id" => "database"
        ],
        [
            "name" =>'Email',
            "id" => "email"
        ],
        [
            "name" => 'SMS Misr',
            "id" => "sms-misr"
        ],
        [
            "name" =>'Slack',
            "id" => "slack",
        ],
        [
            "name" => 'Discord',
            "id" => "discord"
        ],
        [
            "name" => 'FCM Web',
            "id" => "fcm-web"
        ],
        [
            "name" => 'FCM Mobile',
            "id" => "fcm-api"
        ],
        [
            "name" => 'Pusher Web',
            "id" => "pusher-web"
        ],
        [
            "name" => 'Pusher Mobile',
            "id" => "pusher-api"
        ],
        [
            "name" => 'SMS MessageBird',
            "id" => "sms-messagebird"
        ]

    ],

    "lang" => [
        "ar" => "arabic",
        "en" => "english"
    ],

    "email" => [
        "template" => null
    ],

    "drivers" => [
        "sms-misr" => [
            "environment" => env('SMS_MISR_ENV', 1),
            "username" => env('SMS_MISR_USERNAME'),
            "password" => env('SMS_MISR_PASSWORD'),
            "sender" => env('SMS_MISR_SENDER'),
            "language" => env('SMS_MISR_LANGUAGE', 1),
        ],
        "slack" => [
            "webhook" => env('SLACK_WEBHOOK'),
        ],
        "discord" => [
            "webhook" => env('DISCORD_WEBHOOK'),
        ]
    ],


    "api-model" => \App\Models\User::class
];
