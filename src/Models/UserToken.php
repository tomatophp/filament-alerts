<?php

namespace TomatoPHP\FilamentAlerts\Models;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $table = 'user_has_notifications';

    protected $fillable = [
        'model_type',
        'model_id',
        'provider',
        'provider_token',
    ];
}
