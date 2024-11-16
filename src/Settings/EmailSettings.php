<?php

namespace TomatoPHP\FilamentAlerts\Settings;

use Spatie\LaravelSettings\Settings;

class EmailSettings extends Settings
{
    public string $mail_mailer;

    public string $mail_host;

    public string $mail_port;

    public string $mail_username;

    public string $mail_password;

    public string $mail_encryption;

    public string $mail_from_address;

    public string $mail_from_name;

    public static function group(): string
    {
        return 'email';
    }
}
