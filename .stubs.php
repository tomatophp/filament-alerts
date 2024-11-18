<?php

namespace Filament\Notifications;
use App\Filament\Pages\Pulse;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentAlerts\Services\Drivers\EmailDriver;

{
    /*
     * @method static static sendUse(Model $user, string $driver = EmailDriver::class, array $data=[])
     */
    class Notification
    {
        public function sendUse(Model $user, string $driver = EmailDriver::class, array $data=[]): static {}
    }
}
