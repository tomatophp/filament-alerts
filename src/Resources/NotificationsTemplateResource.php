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
use Guava\FilamentIconPicker\Forms\IconPicker;
use Guava\FilamentIconPicker\Tables\IconColumn;
use Filament\Resources\Concerns\Translatable;
use TomatoPHP\FilamentAlerts\Services\SendNotification;


class NotificationsTemplateResource extends Resource
{
    use Translatable;

    protected static ?string $model = NotificationsTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return "Notifications";
    }

    public static function getNavigationLabel(): string
    {
        return "Templates";
    }


    public static function getTranslatableLocales(): array
    {
        return ['en', 'ar'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               Forms\Components\Grid::make(['default' => 3])
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                            ->collection('image')
                            ->maxFiles(1)
                            ->maxWidth(1024)
                            ->acceptedFileTypes(['image/*'])
                            ->columnSpan(3),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('key')
                            ->unique(table:'notifications_templates', column: 'key', ignoreRecord:true)
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('body')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('url')
                            ->columnSpan(3)
                            ->url()
                            ->maxLength(255),
                        IconPicker::make('icon')
                            ->columnSpan(3)
                            ->default('heroicon-o-check-circle'),
                        Forms\Components\Select::make('type')
                            ->options(collect(config('filament-alerts.types'))->pluck('name', 'id')->toArray())
                            ->default('success'),
                        Forms\Components\Select::make('providers')
                            ->multiple()
                            ->options(collect(config('filament-alerts.providers'))->pluck('name', 'id')->toArray()),
                        Forms\Components\Select::make('action')
                            ->options([
                                'manual' => 'Manual',
                                'system' => 'System',
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('key')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('url')
                    ->searchable(),
                IconColumn::make('icon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('action')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('clone')
                    ->label('Clone')
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
                            ->title(__('Template Cloned Successfully'))
                            ->success()
                            ->send();
                    })
                    ->color('info')
                    ->icon('heroicon-o-document-duplicate'),
                Tables\Actions\Action::make('try')
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
                                ->title(__('Notification Sent Successfully'))
                                ->success()
                                ->send();

                        }catch (\Exception $exception){
                            Notification::make()
                                ->title(__('Please Check Your Provider Settings'))
                                ->danger()
                                ->send();
                        }
                    })
                    ->color('success')
                    ->label('Try')
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
