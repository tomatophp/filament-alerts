<?php

namespace TomatoPHP\FilamentAlerts\Resources;

use App\Models\User;
use Filament\Actions\LocaleSwitcher;
use Filament\Notifications\Notification;
use TomatoPHP\FilamentAlerts\Resources\NotificationsTemplateResource\Pages;
use TomatoPHP\FilamentAlerts\Resources\NotificationsTemplateResource\RelationManagers;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Concerns\Translatable;
use TomatoPHP\FilamentAlerts\Services\SendNotification;
use TomatoPHP\FilamentIcons\Components\IconColumn;
use TomatoPHP\FilamentIcons\Components\IconPicker;


class NotificationsTemplateResource extends Resource
{
    use Translatable;

    protected static ?string $model = NotificationsTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return trans('filament-alerts::messages.group');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-alerts::messages.templates.title');
    }
    public static function getLabel(): ?string
    {
        return trans('filament-alerts::messages.templates.single');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('filament-alerts::messages.templates.title');
    }

    public static function getTranslatableLocales(): array
    {
        return array_keys(filament('filament-alerts')->lang);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               Forms\Components\Grid::make(['default' => 3])
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                            ->label(trans('filament-alerts::messages.templates.form.image'))
                            ->collection('image')
                            ->maxFiles(1)
                            ->maxWidth(1024)
                            ->acceptedFileTypes(['image/*'])
                            ->columnSpan(3),
                        Forms\Components\TextInput::make('name')
                            ->label(trans('filament-alerts::messages.templates.form.name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('key')
                            ->label(trans('filament-alerts::messages.templates.form.key'))
                            ->unique(table:'notifications_templates', column: 'key', ignoreRecord:true)
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title')
                            ->label(trans('filament-alerts::messages.templates.form.title'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('body')
                            ->label(trans('filament-alerts::messages.templates.form.body'))
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('url')
                            ->label(trans('filament-alerts::messages.templates.form.url'))
                            ->columnSpan(3)
                            ->url()
                            ->maxLength(255),
                        IconPicker::make('icon')
                            ->label(trans('filament-alerts::messages.templates.form.icon'))
                            ->columnSpan(3)
                            ->default('heroicon-o-check-circle'),
                        Forms\Components\Select::make('type')
                            ->label(trans('filament-alerts::messages.templates.form.type'))
                            ->options(collect(config('filament-alerts.types'))->pluck('name', 'id')->toArray())
                            ->default('success'),
                        Forms\Components\Select::make('providers')
                            ->label(trans('filament-alerts::messages.templates.form.providers'))
                            ->multiple()
                            ->options(collect(config('filament-alerts.providers'))->pluck('name', 'id')->toArray()),
                        Forms\Components\Select::make('action')
                            ->label(trans('filament-alerts::messages.templates.form.action'))
                            ->options([
                                'manual' => trans('filament-alerts::messages.templates.form.manual'),
                                'system' => trans('filament-alerts::messages.templates.form.system'),
                            ])
                            ->default('manual'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('filament-alerts::messages.templates.form.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('key')
                    ->label(trans('filament-alerts::messages.templates.form.key'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(trans('filament-alerts::messages.templates.form.title'))
                    ->searchable(),
                IconColumn::make('icon')
                    ->label(trans('filament-alerts::messages.templates.form.icon'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(trans('filament-alerts::messages.templates.form.type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('action')
                    ->label(trans('filament-alerts::messages.templates.form.action'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('filament-alerts::messages.templates.form.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(trans('filament-alerts::messages.templates.form.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('action')
                    ->label(trans('filament-alerts::messages.templates.form.action'))
                    ->searchable()
                    ->options([
                        'manual' => trans('filament-alerts::messages.templates.form.manual'),
                        'system' => trans('filament-alerts::messages.templates.form.system'),
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->label(trans('filament-alerts::messages.templates.form.type'))
                    ->searchable()
                    ->options(collect(config('filament-alerts.types'))->pluck('name', 'id')->toArray()),
            ])
            ->actions([
                Tables\Actions\Action::make('clone')
                    ->label(trans('filament-alerts::messages.templates.actions.clone'))
                    ->requiresConfirmation()
                    ->action(function(NotificationsTemplate $record) {

                        NotificationsTemplate::create([
                            "name" => $record->name . " (Clone)",
                            "key" => $record->key . "-clone-".time(),
                            "title" => $record->title . " (Clone)",
                            "body" => $record->body,
                            "url" => $record->url,
                            "icon" => $record->icon,
                            "type" => $record->type,
                            "providers" => $record->providers,
                            "action" => $record->action,
                        ]);

                        Notification::make()
                            ->title(trans('filament-alerts::messages.templates.actions.clone-notification'))
                            ->success()
                            ->send();
                    })
                    ->color('info')
                    ->icon('heroicon-o-document-duplicate'),
                Tables\Actions\Action::make('try')
                    ->label(trans('filament-alerts::messages.templates.actions.try'))
                    ->requiresConfirmation()
                    ->action(function(NotificationsTemplate $record){
                        $matchesTitle = array();
                        preg_match('/{.*?}/', $record->title, $matchesTitle);
                        $titleFill = [];
                        foreach ($matchesTitle as $titleItem) {
                            $titleFill[] = "test-title";
                        }
                        $matchesBody = array();
                        preg_match('/{.*?}/', $record->body, $matchesBody);
                        $titleBody = [];
                        foreach ($matchesBody as $bodyItem) {
                            $titleBody[] = "test-body";
                        }

                        try {
                            SendNotification::make($record->providers)
                                ->template($record->key)
                                ->findTitle($matchesTitle)
                                ->replaceTitle($titleFill)
                                ->findBody($matchesBody)
                                ->replaceBody($titleBody)
                                ->model(User::class)
                                ->id(User::first()->id)
                                ->privacy('private')
                                ->fire();

                            Notification::make()
                                ->title(trans('filament-alerts::messages.templates.actions.try-notification'))
                                ->success()
                                ->send();

                        }catch (\Exception $exception){
                            Notification::make()
                                ->title(trans('filament-alerts::messages.templates.actions.try-notification-danger'))
                                ->danger()
                                ->send();
                        }
                    })
                    ->color('success')
                    ->icon('heroicon-o-paper-airplane'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotificationsTemplates::route('/'),
            'create' => Pages\CreateNotificationsTemplate::route('/create'),
            'edit' => Pages\EditNotificationsTemplate::route('/{record}/edit'),
        ];
    }
}
