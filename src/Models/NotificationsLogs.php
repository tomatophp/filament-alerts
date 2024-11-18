<?php

namespace TomatoPHP\FilamentAlerts\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class NotificationsLogs extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $table = 'notifications_logs';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'id',
        'model_type',
        'model_id',
        'title',
        'description',
        'type',
        'provider',
    ];

    public function model()
    {
        return $this->morphTo();
    }
}
