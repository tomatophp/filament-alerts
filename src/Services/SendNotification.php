<?php

namespace TomatoPHP\FilamentAlerts\Services;

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
    /*
     * Actions
     */
    use FireEvent;
    use HasCreatedBy;
    use HasData;
    use HasFindBody;
    use HasFindTitle;
    use HasIcon;
    use HasId;
    use HasImage;
    use HasLang;
    use HasMessage;
    use HasModel;
    use HasPrivacy;
    use HasProviders;
    use HasReplaceBody;
    use HasReplaceTitle;
    use HasTemplate;
    use HasTemplateModel;
    use HasTitle;
    use HasType;
    use HasUrl;

    use HasUser;
    use IsDatabase;
    use LoadTemplate;
    use SendToDatabase;
    use SendToJob;

    public static function make(?array $providers): static
    {
        return (new static)->providers($providers);
    }
}
