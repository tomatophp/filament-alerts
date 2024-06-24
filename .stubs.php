<?php

namespace Filament\Notifications;
use Illuminate\Database\Eloquent\Model;

{
    /*
     * @method static static sendToFCM(Model $user, array $data=[])
     * @method static static sendToEmail(Model $user)
     * @method static static sendToSlack(Model $user)
     * @method static static sendToDiscord(Model $user)
     * @method static static sendToSMSMisr(Model $user)
     * @method static static sendToFCM(Model $user)
     */
    class Notification
    {
        public function sendToEmail(Model $user): static {}
        public function sendToSlack(Model $user): static {}
        public function sendToDiscord(Model $user): static {}
        public function sendToSMSMisr(Model $user): static {}
    }
}
