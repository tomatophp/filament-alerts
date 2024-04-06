<?php

namespace TomatoPHP\FilamentAlerts\Services;

use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Models\UserNotification;
use TomatoPHP\FilamentAlerts\Jobs\NotificationJop;
use TomatoPHP\FilamentAlerts\Services\Actions\FireEvent;
use TomatoPHP\FilamentAlerts\Services\Actions\LoadTemplate;
use TomatoPHP\FilamentAlerts\Services\Actions\SendToDatabase;
use TomatoPHP\FilamentAlerts\Services\Actions\SendToJob;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasCreatedBy;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasData;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasFindBody;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasFindTitle;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasIcon;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasId;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasImage;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasLang;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasMessage;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasModel;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasPrivacy;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasProviders;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasReplaceBody;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasReplaceTitle;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasTemplate;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasTemplateModel;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasTitle;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasType;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasUrl;
use TomatoPHP\FilamentAlerts\Services\Concerns\HasUser;
use TomatoPHP\FilamentAlerts\Services\Concerns\IsDatabase;

class SendNotification
{
    use HasTitle;
    use HasMessage;
    use HasType;
    use HasProviders;
    use HasPrivacy;
    use HasUrl;
    use HasImage;
    use HasIcon;
    use HasModel;
    use HasTemplate;
    use HasFindTitle;
    use HasFindBody;
    use HasReplaceTitle;
    use HasReplaceBody;
    use HasId;
    use HasCreatedBy;
    use HasUser;
    use HasLang;
    use HasTemplateModel;
    use IsDatabase;

    /*
     * Actions
     */
    use FireEvent;
    use LoadTemplate;
    use SendToDatabase;
    use SendToJob;
    use HasData;
    /**
     * @param ?array $providers
     * @return static
     */
    public static function make(?array $providers): static
    {
        return (new static)->providers($providers);
    }
}
