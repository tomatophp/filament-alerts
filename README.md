![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-alerts/master/arts/3x1io-tomato-alerts.jpg)

# Filament Alerts Sender

[![Dependabot Updates](https://github.com/tomatophp/filament-alerts/actions/workflows/dependabot/dependabot-updates/badge.svg)](https://github.com/tomatophp/filament-alerts/actions/workflows/dependabot/dependabot-updates)
[![PHP Code Styling](https://github.com/tomatophp/filament-alerts/actions/workflows/fix-php-code-styling.yml/badge.svg)](https://github.com/tomatophp/filament-alerts/actions/workflows/fix-php-code-styling.yml)
[![Tests](https://github.com/tomatophp/filament-alerts/actions/workflows/tests.yml/badge.svg)](https://github.com/tomatophp/filament-alerts/actions/workflows/tests.yml)
[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-alerts/version.svg)](https://packagist.org/packages/tomatophp/filament-alerts)
[![License](https://poser.pugx.org/tomatophp/filament-alerts/license.svg)](https://packagist.org/packages/tomatophp/filament-alerts)
[![Downloads](https://poser.pugx.org/tomatophp/filament-alerts/d/total.svg)](https://packagist.org/packages/tomatophp/filament-alerts)

Send notification to users using notification templates and multi notification channels, it's support Filament Native Notification Service with macro, and a full integration to FCM service worker notifications

## Features

- [x] Send Notification to users using drivers
- [x] Use Filament Native Notification
- [x] Use Notification Templates
- [x] Notification Logs
- [x] Use Multiple Notification Channels
- [x] Hide Notifications Resources
- [x] Use Database Driver
- [x] Use Email Driver
- [x] Custom Driver Register
- [x] Custom Type Register
- [x] Custom Action Register
- [x] Multi Users Register
- [ ] Register Notification Templates

## Screenshots

![Templates](https://raw.githubusercontent.com/tomatophp/filament-alerts/master/arts/templates.png)
![Create Template](https://raw.githubusercontent.com/tomatophp/filament-alerts/master/arts/create-template.png)
![Create Template Image](https://raw.githubusercontent.com/tomatophp/filament-alerts/master/arts/create-template-v2.png)
![Edit Template](https://raw.githubusercontent.com/tomatophp/filament-alerts/master/arts/edit-template.png)
![Logs](https://raw.githubusercontent.com/tomatophp/filament-alerts/master/arts/logs.png)
![Send Notification](https://raw.githubusercontent.com/tomatophp/filament-alerts/master/arts/send.png)
![Try](https://raw.githubusercontent.com/tomatophp/filament-alerts/master/arts/try.png)
![View Template](https://raw.githubusercontent.com/tomatophp/filament-alerts/master/arts/view-template.png)

## Installation

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
    ->sendUse(auth()->user(), \TomatoPHP\FilamentAlerts\Services\Drivers\EmailDriver::class);
  
```

### Notification Service

to create a new template you can use template CRUD and make sure that the template key is unique because you will use it on every single notification.

### Send Notification

to send a notification you must use our helper SendNotification::class like

```php
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;

FilamentAlerts::notify(User::first())
    ->template($template->id)
    ->title([
        "find-text" => "change with this"
    ])
    ->body([
        "find-text" => "change with this"
    ])
    ->send();
```

where `$template` is selected of the template by key or id, and title, body use to select and replace string on the template with custom data

### Notification Channels

you can use multiple notification channels like

- Email
- Database

it can be working with direct user methods like

```php
$user->notifyEmail(string $message, ?string $subject = null, ?string $url = null);
$user->notifyDB(string $message, ?string $title=null, ?string $url =null);
```

### Hide Notifications Resources

to hide the notification resources from the sidebar you can use the plugin method `hideNotificationsResources` like

```php
->plugin(\TomatoPHP\FilamentAlerts\FilamentAlertsPlugin::make()
    ->hideNotificationsResources()
)
```

## Use Email Settings

we have build a Email settings to change your SMTP settings direct from GUI to allow this feature just add this method to the plugin

```php
->plugin(\TomatoPHP\FilamentAlerts\FilamentAlertsPlugin::make()
    ->useSettingsHub()
)
```

## Add Custom Driver

you can add a custom driver follow up `Driver` abstract class like this

```php
<?php

namespace TomatoPHP\FilamentAlerts\Services\Drivers;

use TomatoPHP\FilamentAlerts\Jobs\NotifyDatabaseJob;

class DatabaseDriver extends Driver
{
    public function setup(): void
    {
        // TODO: Implement setup() method.
    }

    public function sendIt(
        string $title,
        string $model,
        int | string | null $modelId = null,
        ?string $body = null,
        ?string $url = null,
        ?string $icon = null,
        ?string $image = null,
        ?string $type = 'info',
        ?string $action = 'system',
        ?array $data = [],
        ?int $template_id = null,
    ): void {
        if ($modelId) {
            dispatch(new NotifyDatabaseJob([
                'model_type' => $model,
                'modelId' => $modelId,
                'title' => $title,
                'body' => $body,
                'url' => $url,
                'icon' => $icon,
                'type' => $type,
                'action' => $action,
                'data' => $data,
                'template_id' => $template_id,
            ]));
        } else {
            foreach ($model::all() as $user) {
                dispatch(new NotifyDatabaseJob([
                    'model_type' => $model,
                    'modelId' => $user->id,
                    'title' => $title,
                    'body' => $body,
                    'url' => $url,
                    'icon' => $icon,
                    'type' => $type,
                    'action' => $action,
                    'data' => $data,
                    'template_id' => $template_id,
                ]));
            }
        }

    }
}

```


then just use the facade service method in your service provider `boot()`

```php
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;

public function boot() {
    FilamentAlerts::register(
        \TomatoPHP\FilamentAlerts\Services\Concerns\NotificationDriver::make('database')
            ->label('Database')
            ->color('primary')
            ->icon('heroicon-o-bell')
            ->driver(\TomatoPHP\FilamentAlerts\Services\Drivers\DatabaseDriver::class)
    );
} 
```

## Register Custom Type

you can add a custom type using facade service method in your service provider `boot()`

```php
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;

public function boot() {
    FilamentAlerts::register(
        \TomatoPHP\FilamentAlerts\Services\Concerns\NotificationType::make('system')
            ->label('System')
            ->color('primary')
            ->icon('heroicon-o-bell')
    );
} 
```

## Register Custom Action

you can add a custom action using facade service method in your service provider `boot()`

```php
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;

public function boot() {
    FilamentAlerts::register(
        \TomatoPHP\FilamentAlerts\Services\Concerns\NotificationAction::make('system')
            ->label('System')
            ->color('primary')
            ->icon('heroicon-o-bell')
    );
} 
```

## Register Custom User Type

you can add a custom user type using facade service method in your service provider `boot()`

```php
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;

public function boot() {
    FilamentAlerts::register(
        \TomatoPHP\FilamentAlerts\Services\Concerns\NotificationUser::make(User::class)
            ->label('User')
            ->color('primary')
            ->icon('heroicon-o-bell')
    );
} 
```

## User Alerts Resource Hooks

we have add a lot of hooks to make it easy to attach actions, columns, filters, etc

### Table Columns

```php
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateTable;

public function boot()
{
    NotificationsTemplateTable::register([
        \Filament\Tables\Columns\TextColumn::make('something')
    ]);
}
```

### Table Actions

```php
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateActions;

public function boot()
{
    NotificationsTemplateActions::register([
        \Filament\Tables\Actions\ReplicateAction::make()
    ]);
}
```

### Table Filters

```php
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateFilters;

public function boot()
{
    NotificationsTemplateFilters::register([
        \Filament\Tables\Filters\SelectFilter::make('something')
    ]);
}
```

### Table Bulk Actions

```php
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateBulkActions;

public function boot()
{
    NotificationsTemplateBulkActions::register([
        \Filament\Tables\BulkActions\DeleteAction::make()
    ]);
}
```

### From Components

```php
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\NotificationsTemplateForm;

public function boot()
{
    NotificationsTemplateForm::register([
        \Filament\Forms\Components\TextInput::make('something')
    ]);
}
```

### Page Actions

```php
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions\ManagePageActions;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions\EditPageActions;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions\ViewPageActions;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions\CreatePageActions;

public function boot()
{
    ManagePageActions::register([
        Filament\Actions\Action::make('action')
    ]);
    
    EditPageActions::register([
        Filament\Actions\Action::make('action')
    ]);
    
    ViewPageActions::register([
        Filament\Actions\Action::make('action')
    ]);
    
    CreatePageActions::register([
        Filament\Actions\Action::make('action')
    ]);
}
```

### Infolist Entries

```php
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Infolist\NotificationsTemplateInfoList;

public function boot()
{
    NotificationsTemplateInfoList::register([
       \Filament\Infolists\Components\TextEntry::make('something')
    ]);
}
```

## Custom Resource Classes

you can customize all resource classes to be any class you want with the same return from the config file

```php
/**
 * ---------------------------------------------
 * Resource Building
 * ---------------------------------------------
 * if you want to use the resource custom class
 */
'resource' => [
    'table' => [
        'class' => \TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateTable::class,
        'filters' => \TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateFilters::class,
        'actions' => \TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateActions::class,
        'header-actions' => \TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateHeaderActions::class,
        'bulkActions' => \TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateBulkActions::class,
    ],
    'form' => [
        'class' => \TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\NotificationsTemplateForm::class,
    ],
    'infolist' => [
        'class' => \TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Infolist\NotificationsTemplateInfoList::class,
    ],
    'pages' => [
        'list' => \TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions\ManagePageActions::class,
        'create' => \TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions\CreatePageActions::class,
        'edit' => \TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions\EditPageActions::class,
        'view' => \TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Actions\ViewPageActions::class,
    ],
]
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

## Testing

if you like to run `PEST` testing just use this command

```bash
composer test
```

## Code Style

if you like to fix the code style just use this command

```bash
composer format
```

## PHPStan

if you like to check the code by `PHPStan` just use this command

```bash
composer analyse
```

## Other Filament Packages

Checkout our [Awesome TomatoPHP](https://github.com/tomatophp/awesome)
