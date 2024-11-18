<?php

namespace TomatoPHP\FilamentAlerts\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TomatoPHP\FilamentAlerts\Tests\Models\NotificationsTemplate;

class NotificationTemplateFactory extends Factory
{
    protected $model = NotificationsTemplate::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'key' => str($this->faker->name)->slug(),
            'body' => [
                'en' => $this->faker->sentence,
                'ar' => $this->faker->sentence,
            ],
            'title' => [
                'en' => $this->faker->sentence,
                'ar' => $this->faker->sentence,
            ],
            'url' => $this->faker->url,
            'icon' => 'heroicon-o-bell',
            'type' => 'info',
            'providers' => ['database', 'email'],
            'action' => 'system',
        ];
    }
}
