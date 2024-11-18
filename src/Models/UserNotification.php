<?php

namespace TomatoPHP\FilamentAlerts\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class UserNotification extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $table = 'user_notifications';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $datas = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public $fillable = [
        'id',
        'created_by',
        'model_type',
        'model_id',
        'title',
        'url',
        'icon',
        'description',
        'type',
        'privacy',
        'template_id',
        'data',
    ];

    public function model()
    {
        return $this->morphTo();
    }

    public function template()
    {
        return $this->hasOne(NotificationsTemplate::class, 'id', 'template_id');
    }

    public function read()
    {
        $checkExists = $this->userRead()->where('model_type', $this->model_type)->where('model_id', $this->model_id)->first();
        if (! $checkExists) {
            $this->userRead()->create([
                'model_type' => $this->model_type,
                'model_id' => $this->model_id,
                'read' => true,
                'open' => true,
            ]);
        }

    }

    public function isRead()
    {
        $checkExists = $this->userRead()->where('model_type', $this->model_type)->where('model_id', $this->model_id)->first();
        if ($checkExists) {
            return $checkExists->read;
        }

        return false;
    }

    public function userRead()
    {
        return $this->hasMany(UserReadNotification::class, 'notification_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(config('filament-alerts.try.model')::class, 'created_by', 'id');
    }
}
