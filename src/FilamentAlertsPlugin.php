<?php

namespace TomatoPHP\FilamentAlerts;

use Filament\Contracts\Plugin;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Filament\Panel;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;
use Nwidart\Modules\Module;
use TomatoPHP\FilamentAlerts\Resources\NotificationsLogsResource;
use TomatoPHP\FilamentAlerts\Resources\NotificationsTemplateResource;
use TomatoPHP\FilamentAlerts\Resources\UserNotificationResource;
use TomatoPHP\FilamentAlerts\Pages\EmailSettingsPage;
use TomatoPHP\FilamentAlerts\Pages\NotificationsSettingsPage;
use TomatoPHP\FilamentSettingsHub\Facades\FilamentSettingsHub;
use TomatoPHP\FilamentSettingsHub\Services\Contracts\SettingHold;


class FilamentAlertsPlugin implements Plugin
{
    private bool $isActive = false;

    public function getId(): string
    {
        return 'filament-alerts';
    }

    public ?bool $useSettingHub = false;
    public ?bool $hideNotificationsResource = false;
    public ?array $types = [
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
    ];
    public ?array $models = [
        \App\Models\User::class => "Admins",
    ];
    public ?array $providers = [
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
            "name" => 'Reverb',
            "id" => "reverb"
        ],
        [
            "name" => 'SMS MessageBird',
            "id" => "sms-messagebird"
        ]

    ];
    public ?array $lang = [
        "ar" => "arabic",
        "en" => "english"
    ];
    public ?bool $useDatabase = true;
    public ?bool $useFCM = false;
    public ?bool $useSlack = false;
    public ?bool $useDiscord = false;
    public ?bool $useReverb = false;
    public ?bool $useEmail= true;
    public ?bool $useSMSMisr = false;
    public ?bool $useMessageBird = false;
    public ?string $apiModel = \App\Models\User::class;

    public function register(Panel $panel): void
    {
        if(class_exists(Module::class) && \Nwidart\Modules\Facades\Module::find('FilamentAlerts')?->isEnabled()){
            $this->isActive = true;
        }
        else {
            $this->isActive = true;
        }

        if($this->isActive) {

            $panel
                ->plugin(SpatieLaravelTranslatablePlugin::make())
                ->resources((!$this->hideNotificationsResource) ? [
                    NotificationsLogsResource::class,
                    UserNotificationResource::class,
                    NotificationsTemplateResource::class
                ] : [])
                ->pages($this->useSettingHub ? [
                    NotificationsSettingsPage::class,
                    EmailSettingsPage::class
                ] : []);
        }

    }

    public function hideNotificationsResource(?bool $hideNotificationsResource = true): static
    {
        $this->hideNotificationsResource = $hideNotificationsResource;
        return $this;
    }

    public function useSettingsHub(?bool $useSettingHub = true): static
    {
        $this->useSettingHub = $useSettingHub;
        return $this;
    }

    public function types(?array $types = []): static
    {
        $this->types = $types;
        return $this;
    }

    public function models(?array $models = []): static
    {
        $this->models = $models;
        return $this;
    }

    public function providers(?array $providers = []): static
    {
        $this->providers = $providers;
        return $this;
    }

    public function lang(?array $lang = []): static
    {
        $this->lang = $lang;
        return $this;
    }

    public function useDatabase(?bool $useDatabase = true): static
    {
        $this->useDatabase = $useDatabase;
        return $this;
    }

    public function useFCM(?bool $useFCM = true): static
    {
        $this->useFCM = $useFCM;
        return $this;
    }

    public function useSlack(?bool $useSlack = true): static
    {
        $this->useSlack = $useSlack;
        return $this;
    }

    public function useDiscord(?bool $useDiscord = true): static
    {
        $this->useDiscord = $useDiscord;
        return $this;
    }

    public function useReverb(?bool $useReverb = true): static
    {
        $this->useReverb = $useReverb;
        return $this;
    }

    public function useEmail(?bool $useEmail = true): static
    {
        $this->useEmail = $useEmail;
        return $this;
    }

    public function useSMSMisr(?bool $useSMSMisr = true): static
    {
        $this->useSMSMisr = $useSMSMisr;
        return $this;
    }

    public function apiModel(?string $apiModel = \App\Models\User::class): static
    {
        $this->apiModel = $apiModel;
        return $this;
    }

    public function boot(Panel $panel): void
    {
        if(class_exists(Module::class)){
            if(\Nwidart\Modules\Facades\Module::find('FilamentAlerts')->isEnabled()){
                $this->isActive = true;
            }
        }
        else {
            $this->isActive = true;
        }

        if($this->isActive) {
            if (class_exists(FilamentSettingsHub::class) && $this->useSettingHub) {
                FilamentSettingsHub::register([
                    SettingHold::make()
                        ->label('filament-alerts::messages.settings.firebase.title')
                        ->icon('heroicon-o-fire')
                        ->page(NotificationsSettingsPage::class)
                        ->order(2)
                        ->description('filament-alerts::messages.settings.firebase.description')
                        ->group('filament-alerts::messages.settings.group'),
                    SettingHold::make()
                        ->label('filament-alerts::messages.settings.email.title')
                        ->icon('heroicon-o-envelope')
                        ->page(EmailSettingsPage::class)
                        ->order(2)
                        ->description('filament-alerts::messages.settings.email.description')
                        ->group('filament-alerts::messages.settings.group'),
                ]);


                try {
                    Config::set('mail.mailers.smtp', [
                        'transport' => setting('mail_mailer'),
                        'host' => setting('mail_host'),
                        'port' => setting('mail_port'),
                        'encryption' => setting('mail_encryption'),
                        'username' => setting('mail_username'),
                        'password' => setting('mail_password'),
                        'timeout' => null,
                        'auth_mode' => null,
                    ]);

                    Config::set('mail.from', [
                        'address' => setting('mail_from_address'),
                        'name' => setting('mail_from_name'),
                    ]);

                    Config::set('firebase.projects.app', [
                        'credentials' => env('FIREBASE_CREDENTIALS', public_path('storage/' . setting('fcm_cr'))),
                        'database' => [
                            'url' => env('FIREBASE_DATABASE_URL', setting('fcm_database_url')),
                        ]
                    ]);

                } catch (\Exception $e) {
                    \Log::error($e);
                }
            }

            Config::set('filament-alerts.provider', count($this->providers) ? $this->providers : []);
            Config::set('filament-alerts.models', count($this->models) ? $this->models : []);
            Config::set('filament-alerts.lang', count($this->lang) ? $this->lang : []);
            Config::set('filament-alerts.types', count($this->types) ? $this->types : []);

            if ($this->useEmail) {
                Notification::macro('sendToEmail', function (Model $user): static {
                    /** @var Notification $this */
                    $user->notifyEmail(
                        message: $this->body,
                        subject: $this->title,
                        url: count($this->actions) ? $this->actions[0]->getUrl() ?? null : null
                    );

                    return $this;
                });
            }

            if ($this->useSlack) {
                Notification::macro('sendToSlack', function (Model $user): static {
                    /** @var Notification $this */
                    $user->notifySlack(
                        title: $this->title,
                        message: $this->body,
                        url: count($this->actions) ? $this->actions[0]->getUrl() : null,
                        webhook: config('filament-alerts.drivers.slack.webhook')
                    );

                    return $this;
                });
            }

            if ($this->useDiscord) {
                Notification::macro('sendToDiscord', function (Model $user): static {
                    /** @var Notification $this */
                    $user->notifyDiscord(
                        title: $this->title,
                        message: $this->body,
                        url: count($this->actions) ? $this->actions[0]->getUrl() : null,
                        webhook: config('filament-alerts.drivers.discord.webhook')
                    );

                    return $this;
                });
            }

            if ($this->useSMSMisr) {
                Notification::macro('sendToSMSMisr', function (Model $user): static {
                    /** @var Notification $this */
                    $user->notifySMSMisr(
                        message: $this->body
                    );

                    return $this;
                });
            }

            if ($this->useFCM) {
                $this->providers = array_merge($this->providers, [
                    [
                        "name" => 'FCM Web',
                        "id" => "fcm-web"
                    ],
                    [
                        "name" => 'FCM Mobile',
                        "id" => "fcm-api"
                    ],
                ]);
            }
        }
    }

    public static function make(): static
    {
        return new static();
    }
}
