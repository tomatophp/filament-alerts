<?php

namespace TomatoPHP\FilamentAlerts\Services\Notifications\Traits;


use Illuminate\Support\Facades\App;
use Modules\Accounts\Entities\Account;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Services\SendNotification;

trait HandleNotificationsTrait
{
    public function sendNotification($ids, $template, $body = [], $bodyKeys = [], $title = [], $data)
    {
        $templateModel = NotificationsTemplate::where('key', $template)->first();

        foreach ($ids as $id) {
            // refactor get pluck lang and id and get value based on where condition
            $account = Account::find($id);

            if ($account->notification_toggle) {
                App::setLocale($account->lang);
                $translated = [];
                foreach ($body as $key) {
//                if (gettype($key) == 'string')
                    $translated[] = __($key);
                }

                SendNotification::make($templateModel->providers)
                    ->template($template)
                    ->templateModel($templateModel)
                    ->findBody($bodyKeys ?? '')
                    ->replaceBody($translated ?? '')
                    ->model(Account::class)
                    ->id($account->id)
                    ->url("khaleds")
                    ->data(json_encode($data))
                    ->privacy('private')
                    ->database(true)
                    ->lang($account->lang)
                    ->fire();

            }
        }
    }
}
