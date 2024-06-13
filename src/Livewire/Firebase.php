<?php

namespace TomatoPHP\FilamentAlerts\Livewire;

use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class Firebase extends Component
{
    #[On('fcm-token')]
    public function fcmToken(string $token)
    {
        if(auth()->user()){
            $user = auth()->user();
            $user->setFCM('fcm-web')->userTokensFcm()->firstOrCreate([
                'provider' => 'fcm-web',
                'provider_token' => $token
            ]);
        }
    }

    #[On('fcm-notification')]
    public function fcmNotification(mixed $data)
    {
        $actions = [];
        if(isset($data['data'])){
            if(isset($data['data']['actions']) && is_object(json_decode($data['data']['actions']))){
                foreach (json_decode($data['data']['actions']) as $action){
                    $actions[] = Action::make($action->name)
                        ->color($action->color)
                        ->eventData($action->eventData)
                        ->icon($action->icon)
                        ->iconPosition($action->iconPosition)
                        ->iconSize($action->iconSize)
                        ->outlined($action->isOutlined)
                        ->disabled($action->isDisabled)
                        ->label($action->label)
                        ->url($action->url)
                        ->close($action->shouldClose)
                        ->size($action->size)
                        ->tooltip($action->tooltip)
                        ->view($action->view)
                        ->markAsUnread($action->shouldMarkAsUnRead??false)
                        ->markAsRead($action->shouldMarkAsRead??false);
                }
            }
        }

        Notification::make($data['data']['id'])
            ->title($data['data']['title'])
            ->actions($actions)
            ->body($data['data']['body'])
            ->icon($data['data']['icon'])
            ->iconColor($data['data']['iconColor'])
            ->color($data['data']['color'])
            ->duration($data['data']['duration'])
            ->send()
            ->sendToDatabase(auth()->user());
    }

    public function render()
    {
        return view('filament-alerts::firebase-base');
    }
}
