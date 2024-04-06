<?php

namespace TomatoPHP\FilamentAlerts\Resources\UserNotificationResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Resources\UserNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentAlerts\Services\SendNotification;

class ManageUserNotifications extends ManageRecords
{
    protected static string $resource = UserNotificationResource::class;

    public function getTitle():string
    {
        return "Notifications";
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
                ->label('Create Notification'),
            Action::make('logs')->action(fn()=> redirect()->route('filament.admin.resources.notifications-logs.index'))->color('info')->label('Logs'),
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
