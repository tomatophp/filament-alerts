<?php

return [
    "group" => "Notifications",
    "back" => "Back",
    "notifications" => [
        "title" => "Notifications",
        "create" => "Create Notification",
        "logs" => "Logs",
        "form" => [
            "user" => "User",
            "template" => "Template",
            "privacy" => "Privacy",
            "user_type" => "User Type",
            "createdBy" => "Created By",
            "created_at" => "Created At",
            "updated_at" => "Updated At",
        ]
    ],
    "templates" => [
        "title" => "Templates",
        "create" => "Create Template",
        "edit" => "Edit Template",
        "actions" => [
          "clone" => "Clone",
          "try" => "Try",
          "clone-notification" => "Template has been cloned",
          "try-notification" => "Template has been sent",
          "try-notification-danger" => "Sorry something warrning when sending the notification",
        ],
        "form" => [
            "image" => "Image",
            "name" => "Name",
            "key" => "Key",
            "title" => "Title",
            "body" => "Body",
            "url" => "Url",
            "icon" => "Icon",
            "providers" => "Providers",
            "type" => "Type",
            "action" => "Action",
            "manual" => "Manual",
            "system" => "System",
            "created_at" => "Created At",
            "updated_at" => "Updated At",
        ]
    ],
    "logs" => [
        "title" => "Logs",
        "form" => [
            "user" => "User",
            "title" => "Title",
            "type" => "Type",
            "provider" => "Provider",
            "created_at" => "Created At",
            "updated_at" => "Updated At",
        ]
    ],
    "settings" => [
        "group" => "Notifications",
        "firebase" => [
            "title" => "Firebase Settings",
            "description" => "Update firebase connection settings",
            "notifications_allow" => "Allow Notifications",
            "fcm_apiKey" => "FCM API Key",
            "fcm_authDomain" => "FCM Auth Domain",
            "fcm_projectId" => "FCM Project Id",
            "fcm_storageBucket" => "FCM Storage Bucket",
            "fcm_messagingSenderId" => "FCM Messaging Sender Id",
            "fcm_appId" => "FCM App Id",
            "fcm_measurementId" => "FCM Measurement Id",
            "fcm_cr" => "FCM Admin Json",
            "fcm_database_url" => "FCM Database Url",
            "fcm_vapid" => "FCM Vapid",
        ],
        "email" => [
            "title" => "Email Settings",
            "description" => "Update email provider connection settings",
            "mail_mailer" => "Mailer",
            "mail_host" => "Host",
            "mail_port" => "Port",
            "mail_username" => "Username",
            "mail_password" => "Password",
            "mail_encryption" => "Encryption",
            "mail_from_address" => "From address",
            "mail_from_name" => "From Name",
        ]
    ]
];
