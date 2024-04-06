<?php

namespace TomatoPHP\FilamentAlerts\Models;

use Illuminate\Database\Eloquent\Model;

class UserReadNotification extends Model
{
    protected $table = 'user_read_notifications';

    protected $fillable = [
        'notification_id',
        'model_type',
        'model_id',
        'read',
        'open',
    ];

    public function userNotification()
    {
        return $this->belongsTo(UserNotification::class, 'notification_id');
    }

    public function model()
    {
        return $this->morphTo();
    }
}
