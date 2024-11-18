<?php

namespace TomatoPHP\FilamentAlerts\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Models\Role;
use Spatie\Translatable\HasTranslations;

class NotificationsTemplate extends Model implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    public $translatable = ['title', 'body'];

    public $fillable = [
        'id',
        'name',
        'key',
        'body',
        'title',
        'url',
        'icon',
        'type',
        'providers',
        'action',
    ];

    protected $casts = [
        'providers' => 'json',
        'title' => 'json',
        'body' => 'json',
    ];

    public function roles()
    {
        if (class_exists(Role::class)) {
            return $this->belongsToMany(Role::class, 'template_has_roles', 'template_id', 'role_id');
        }
    }
}
