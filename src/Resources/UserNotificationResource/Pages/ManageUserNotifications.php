<?php

namespace TomatoPHP\FilamentAlerts\Resources\UserNotificationResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentAlerts\Models\NotificationsLogs;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Resources\NotificationsLogsResource;
use TomatoPHP\FilamentAlerts\Resources\NotificationsTemplateResource;
use TomatoPHP\FilamentAlerts\Resources\UserNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentAlerts\Services\SendNotification;

class ManageUserNotifications extends ManageRecords
{
    protected static string $resource = UserNotificationResource::class;

    public function getTitle():string
    {
        return trans('filament-alerts::messages.notifications.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function(array $data)
                    {
                        $template = NotificationsTemplate::find($data['template_id']);
                        if($template){
                            $data['title'] = $template->name;
                            $data['body'] = $template->body;
                            $data['icon'] = $template->icon;
                            $data['url'] = $template->url;
                            $data['type'] = $template->type;
                            $data['providers'] = $template->providers;
                            $data['created_by'] = auth()->user()->id;
                        }

                        return $data;
                    }
                )
                ->after(function($record){
                    SendNotification::make($record->template->providers)
                        ->title($record->template->title)
                        ->template($record->template->key)
                        ->database(false)
                        ->privacy($record->privacy)
                        ->model($record->model_type)
                        ->id($record->model_id)
                        ->fire();
                })
                ->label(trans('filament-alerts::messages.notifications.create')),
            Action::make('templates')
                ->icon('heroicon-o-document-text')
                ->hiddenLabel()
                ->action(fn()=> redirect()->to(NotificationsTemplateResource::getUrl('index')))
                ->color('danger')
                ->tooltip(trans('filament-alerts::messages.templates.title'))
                ->label(trans('filament-alerts::messages.templates.title')),
            Action::make('logs')
                ->icon('heroicon-o-archive-box-arrow-down')
                ->hiddenLabel()
                ->action(fn()=> redirect()->to(NotificationsLogsResource::getUrl('index')))
                ->color('info')
                ->tooltip(trans('filament-alerts::messages.notifications.logs'))
                ->label(trans('filament-alerts::messages.notifications.logs')),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $template = NotificationsTemplate::find($data['template_id']);
        dd($template);
        if($template){
            $data['title'] = $template->name;
            $data['body'] = $template->body;
            $data['icon'] = $template->icon;
            $data['url'] = $template->url;
            $data['type'] = $template->type;
            $data['providers'] = $template->providers;
        }

        return $data;
    }

}
