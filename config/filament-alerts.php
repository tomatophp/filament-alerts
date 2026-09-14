<?php

use App\Models\User;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Form\NotificationsTemplateForm;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\InfoList\NotificationsTemplateInfoList;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateActions;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateBulkActions;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateFilters;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateHeaderActions;
use TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\NotificationsTemplateTable;

return [
    /**
     * ---------------------------------------------
     * Default Languages
     * ---------------------------------------------
     * set the default languages
     */
    'lang' => [
        'ar' => 'arabic',
        'en' => 'english',
    ],

    /**
     * ---------------------------------------------
     * Pre Defined Drivers and Actions
     * ---------------------------------------------
     * if you want to use predefined drivers and actions
     */
    'predefined' => [
        'types' => true,
        'actions' => true,
        'users' => true,
        'drivers' => true,
    ],

    /**
     * ---------------------------------------------
     * Custom Email Template
     * ---------------------------------------------
     * if you want to use custom email template
     */
    'email' => [
        'template' => null,
    ],

    /**
     * ---------------------------------------------
     * Resource Building
     * ---------------------------------------------
     * if you want to use the resource custom class
     */
    'resource' => [
        'table' => [
            'class' => NotificationsTemplateTable::class,
            'filters' => NotificationsTemplateFilters::class,
            'actions' => NotificationsTemplateActions::class,
            'header-actions' => NotificationsTemplateHeaderActions::class,
            'bulkActions' => NotificationsTemplateBulkActions::class,
        ],
        'form' => [
            'class' => NotificationsTemplateForm::class,
        ],
        'infolist' => [
            'class' => NotificationsTemplateInfoList::class,
        ],
    ],

    /**
     * ---------------------------------------------
     * Try User Model
     * ---------------------------------------------
     * set user model that you can use when you try any template
     */
    'try' => [
        'model' => User::class,
    ],

    /**
     * ---------------------------------------------
     * Queue Name
     * ---------------------------------------------
     * The queue name for notifications dispatching events
     */
    'queue' => env('FILAMENT_ALERTS_QUEUE', 'default'),

];
