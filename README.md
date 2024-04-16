![Screenshot](https://github.com/tomatophp/filament-alerts/blob/master/arts/3x1io-tomato-alerts.jpg)

# Filament Alerts Sender

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-alerts/version.svg)](https://packagist.org/packages/tomatophp/filament-alerts)
[![PHP Version Require](http://poser.pugx.org/tomatophp/filament-alerts/require/php)](https://packagist.org/packages/tomatophp/filament-alerts)
[![License](https://poser.pugx.org/tomatophp/filament-alerts/license.svg)](https://packagist.org/packages/tomatophp/filament-alerts)
[![Downloads](https://poser.pugx.org/tomatophp/filament-alerts/d/total.svg)](https://packagist.org/packages/tomatophp/filament-alerts)

Send notification to users using notification templates and multi notification channels

## Screenshots

![Screenshot](https://github.com/tomatophp/filament-alerts/raw/master/arts/create-template.png)
![Screenshot](https://github.com/tomatophp/filament-alerts/raw/master/arts/notifications.png)
![Screenshot](https://github.com/tomatophp/filament-alerts/raw/master/arts/notify.png)
![Screenshot](https://github.com/tomatophp/filament-alerts/raw/master/arts/templates.png)

## Installation


before use this package make sure you have installed 

- [Filament Spatie Translatable](https://filamentphp.com/plugins/filament-spatie-translatable)
- [Filament Spatie Media Library](https://filamentphp.com/plugins/filament-spatie-media-library)
- [Filament Settings Hub](https://github.com/tomatophp/filament-settings-hub)

```bash
composer require tomatophp/filament-alerts
```

after install your package please run this command

```bash
php artisan filament-alerts:install
```

## Usage

to set up any model to get notifications you

```php
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use TomatoPHP\FilamentAlerts\Traits\InteractsWithNotifications;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use InteractsWithNotifications;
    ...
```

and you must set the settings for FCM to get real-time notification

### Queue

the notification is run on queue, so you must run the queue worker to send the notifications

```bash
php artisan queue:work
```

### Notification Service

to create a new template you can use template CRUD and make sure that the template key is unique because you will use it on every single notification.

### Send Notification

to send a notification you must use our helper SendNotification::class like

```php
SendNotification::make($template->providers)
    ->template($template->key)
    ->findTitle($matchesTitle)
    ->replaceTitle($titleFill)
    ->findBody($matchesBody)
    ->replaceBody($titleBody)
    ->model(User::class)
    ->id(User::first()->id)
    ->privacy('private')
    ->fire();
```

where `$template` is selected of the template by key and $matchesTitle and $matchesBody is an array of matches to replace the template and $titleFill and $titleBody are an array of values to replace the matches


### Notification Channels

you can use multiple notification channels like

- Email
- SMS
- FCM
- Pusher
- Database
- Slack
- Discord

it can be working with direct user methods like

```php
$user->notifySMSMisr(string $message);
$user->notifyEmail(string $message, ?string $subject = null, ?string $url = null);
$user->notifyFCMSDK(string $message, string $type='web', ?string $title=null, ?string $url=null, ?string $image=null, ?string $icon=null, ?array $data=[]);
$user->notifyPusherSDK(string $token, string $title, string $message);
$user->notifyDB(string $message, ?string $title=null, ?string $url =null);
$user->notifySlack(string $title,string $message=null,?string $url=null, ?string $image=null, ?string $webhook=null);
$user->notifyDiscord(string $title,string $message=null,?string $url=null, ?string $image=null, ?string $webhook=null);
```

## API

we are support some API to get the notification and make some actions you can find it under `api/notifications` route

## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="filament-alerts-config"
```

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="filament-alerts-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="filament-alerts-lang"
```

you can publish migrations file by use this command

```bash
php artisan vendor:publish --tag="filament-alerts-migrations"
```



## Support

you can join our discord server to get support [TomatoPHP](https://discord.gg/Xqmt35Uh)

## Docs

you can check docs of this package on [Docs](https://docs.tomatophp.com/plugins/laravel-package-generator)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Fady Mondy](mailto:info@3x1.io)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
