![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-alerts/master/arts/3x1io-tomato-alerts.jpg)

# Filament Alerts Sender

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-alerts/version.svg)](https://packagist.org/packages/tomatophp/filament-alerts)
[![License](https://poser.pugx.org/tomatophp/filament-alerts/license.svg)](https://packagist.org/packages/tomatophp/filament-alerts)
[![Downloads](https://poser.pugx.org/tomatophp/filament-alerts/d/total.svg)](https://packagist.org/packages/tomatophp/filament-alerts)

Send notification to users using notification templates and multi notification channels, it's support Filament Native Notification Service with macro, and a full integration to FCM service worker notifications

## Features

- Send Notification to users
- Use Filament Native Notification
- Use Notification Templates
- Full FCM Service Worker Integration
- Use Multiple Notification Channels
- API to get notifications
- Hide Notifications Resources
- Use Slack Driver
- Use Discord Driver
- Use Reverb Driver
- Use SMS Misr Driver
- Use Email Driver
- Use Database Driver
- Use MessageBird Driver


## Screenshots

![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-alerts/master/arts/create-template.png)
![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-alerts/master/arts/notifications.png)
![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-alerts/master/arts/notify.png)
![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-alerts/master/arts/templates.png)

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

if you are not using this package as a plugin please register the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugin(\TomatoPHP\FilamentAlerts\FilamentAlertsPlugin::make()
)
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

### Use Filament Native Notification

you can use the filament native notification and we add some `macro` for you

```php
use Filament\Notifications\Notification;

Notification::make('send')
    ->title('Test Notifications')
    ->body('This is a test notification')
    ->icon('heroicon-o-bell')
    ->color('success')
    ->actions([
        \Filament\Notifications\Actions\Action::make('view')
            ->label('View')
            ->url('https://google.com')
            ->markAsRead()
    ])
    ->sendToDiscord(auth()->user())
    ->sendToEmail(auth()->user())
    ->broadcast(auth()->user())
    ->sendToDatabase(auth()->user())
    ->sendToSlack(auth()->user())
    ->sendToFCM(auth()->user())
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
- Reverb
- Database
- Slack
- Discord

it can be working with direct user methods like

```php
$user->notifySMSMisr(string $message);
$user->notifyEmail(string $message, ?string $subject = null, ?string $url = null);
$user->notifyFCMSDK(string $message, string $type='web', ?string $title=null, ?string $url=null, ?string $image=null, ?string $icon=null, ?array $data=[]);
$user->notifyDB(string $message, ?string $title=null, ?string $url =null);
$user->notifySlack(string $title,string $message=null,?string $url=null, ?string $image=null, ?string $webhook=null);
$user->notifyDiscord(string $title,string $message=null,?string $url=null, ?string $image=null, ?string $webhook=null);
```

### Use FCM Notifications Provider

to make FCM Notification Work you need to install [Filament Settings Hub](https://www.github.com/tomatophp/filament-settings-hub) and allow use Setting Hub on the Plugin

```php
->plugin(\TomatoPHP\FilamentAlerts\FilamentAlertsPlugin::make()
    ->useSettingsHub()
    ->useFCM()
)
```

than you need to install `filament-fcm` package by use this command

```bash
composer require tomatophp/filament-fcm
```

and add the service provider plugin

```php
->plugin(\TomatoPHP\FilamentFcm\FilamentFcmPlugin::make())
```

now you need to update config


```dotenv
# Firebase Project
FIREBASE_API_KEY=
FIREBASE_AUTH_DOMAIN=
FIREBASE_DATABASE_URL=
FIREBASE_PROJECT_ID=
FIREBASE_STORAGE_BUCKET=
FIREBASE_MESSAGING_SENDER_ID=
FIREBASE_APP_ID=
FIREBASE_MEASUREMENT_ID=

# Firebase Cloud Messaging
FIREBASE_VAPID=

# Firebase Alert Sound
FCM_ALERT_SOUND=
```

than run this command

```bash
php artisan filament-fcm:install
```

it will generate FCM worker for you to make notifications working on the background.


### Hide Notifications Resources

to hide the notification resources from the sidebar you can use the plugin method `hideNotificationsResources` like

```php
->plugin(\TomatoPHP\FilamentAlerts\FilamentAlertsPlugin::make()
    ->hideNotificationsResources()
)
```

### Use Slack Driver

to use slack driver you must set the slack webhook on the settings hub and use the plugin method `useSlack` like

```php
->plugin(\TomatoPHP\FilamentAlerts\FilamentAlertsPlugin::make()
    ->useSlack()
)
```

now on your `.env` file add a `SLACK_WEBHOOK` key with the webhook URL

### Use Discord Driver

to use discord driver you must set the discord webhook on the settings hub and use the plugin method `useDiscord` like

```php
->plugin(\TomatoPHP\FilamentAlerts\FilamentAlertsPlugin::make()
    ->useDiscord()
)
```

now on your `.env` file add a `DISCORD_WEBHOOK` key with the webhook URL

## API

we are support some API to get the notification and make some actions you can find it under `api/notifications` route

you can change the user model by use the plugin method `apiModel` like

```php
->plugin(\TomatoPHP\FilamentAlerts\FilamentAlertsPlugin::make()
    ->apiModel(User::class)
)
```
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

## Other Filament Packages

checkout our [Awesome TomatoPHP](https://github.com/tomatophp/awesome)

## Support

you can join our discord server to get support [TomatoPHP](https://discord.gg/Xqmt35Uh)

## Docs

you can check docs of this package on [Docs](https://docs.tomatophp.com/filament/filament-alerts)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Fady Mondy](https://wa.me/+201207860084)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
