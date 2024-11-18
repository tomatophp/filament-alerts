<?php

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
    ],

    /**
     * ---------------------------------------------
     * Try User Model
     * ---------------------------------------------
     * set user model that you can use when you try any template
     */
    'try' => [
        'model' => \App\Models\User::class,
    ],
];
