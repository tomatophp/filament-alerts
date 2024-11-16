<?php

return [
    'lang' => [
        'ar' => 'arabic',
        'en' => 'english',
    ],

    'drivers' => [],

    'predefined' => [
        'types' => true,
        'actions' => true,
        'users' => true,
        'drivers' => true
    ],

    'email' => [
        "template" => null
    ],


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
];
