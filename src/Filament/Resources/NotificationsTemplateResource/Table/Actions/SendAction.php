<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\Actions;

use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Forms;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;
use TomatoPHP\FilamentAlerts\Services\SendNotification;

class SendAction extends Action
{
    public static function make(): Tables\Actions\Action
    {
        return Tables\Actions\Action::make('send')
            ->requiresConfirmation()
            ->iconButton()
            ->label("Send")
            ->tooltip("Send")
            ->icon('heroicon-o-bell')
            ->form(fn($record) => [
                Forms\Components\Hidden::make('template_id')
                    ->default($record->id),
                Forms\Components\Select::make('privacy')
                    ->label(trans('filament-alerts::messages.notifications.form.privacy'))
                    ->searchable()
                    ->columnSpanFull()
                    ->options([
                        'public' => 'Public',
                        'private' => 'Private',
                    ])
                    ->live()
                    ->required()
                    ->default('public'),
                Forms\Components\Select::make('model_type')
                    ->searchable()
                    ->label(trans('filament-alerts::messages.notifications.form.user_type'))
                    ->options(FilamentAlerts::loadUsers()->pluck('label', 'model')->toArray())
                    ->preload()
                    ->required()
                    ->live(),
                Forms\Components\Select::make('model_id')
                    ->label(trans('filament-alerts::messages.notifications.form.user'))
                    ->searchable()
                    ->hidden(fn (Forms\Get $get): bool => $get('privacy') !== 'private')
                    ->options(fn (Forms\Get $get) => $get('model_type') ? $get('model_type')::pluck('name', 'id')->toArray() : [])
                    ->required(),
            ])
            ->action(function (array $data, $record){
                SendNotification::make($record->providers)
                    ->title($record->title)
                    ->template($record->key)
                    ->database(false)
                    ->privacy($data['privacy'])
                    ->model($data['model_type'])
                    ->id($data['model_id']??null)
                    ->fire();


                Notification::make()
                    ->title('Notification sent')
                    ->success()
                    ->send();
            });
    }
}
