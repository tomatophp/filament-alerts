<?php

namespace TomatoPHP\FilamentAlerts\Filament\Resources\NotificationsTemplateResource\Table\Actions;

use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Tables;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;

class SendAction extends Action
{
    public static function make(): Tables\Actions\Action
    {
        return Tables\Actions\Action::make('send')
            ->requiresConfirmation()
            ->iconButton()
            ->label(trans('filament-alerts::messages.actions.send.label'))
            ->tooltip(trans('filament-alerts::messages.actions.send.label'))
            ->icon('heroicon-o-bell')
            ->form(fn ($record) => [
                Forms\Components\Hidden::make('template_id')
                    ->default($record->id),
                Forms\Components\Select::make('privacy')
                    ->label(trans('filament-alerts::messages.actions.send.form.privacy'))
                    ->searchable()
                    ->columnSpanFull()
                    ->options([
                        'public' => trans('filament-alerts::messages.actions.send.form.public'),
                        'private' => trans('filament-alerts::messages.actions.send.form.private'),
                    ])
                    ->live()
                    ->required()
                    ->default('public'),
                Forms\Components\Select::make('model_type')
                    ->searchable()
                    ->label(trans('filament-alerts::messages.actions.send.form.model_type'))
                    ->options(FilamentAlerts::loadUsers()->pluck('label', 'model')->toArray())
                    ->preload()
                    ->required()
                    ->live(),
                Forms\Components\Select::make('model_id')
                    ->label(trans('filament-alerts::messages.actions.send.form.model_id'))
                    ->searchable()
                    ->hidden(fn (Forms\Get $get): bool => $get('privacy') !== 'private')
                    ->options(fn (Forms\Get $get) => $get('model_type') ? $get('model_type')::pluck('name', 'id')->toArray() : [])
                    ->required(),
            ])
            ->action(function (array $data, $record) {
                FilamentAlerts::notify()
                    ->model($data['model_type'])
                    ->modelId($data['model_id'] ?? null)
                    ->template($record->id)
                    ->send();

                Notification::make()
                    ->title(trans('filament-alerts::messages.actions.send.notification'))
                    ->success()
                    ->send();
            });
    }
}
