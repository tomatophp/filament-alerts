<?php

namespace TomatoPHP\FilamentAlerts\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;

/**
 * @extends Factory<NotificationsTemplate>
 */
class NotificationsTemplateFactory extends Factory
{
    protected $model = NotificationsTemplate::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        return [
            'name' => $name,
            'key' => str($name)->slug()->toString(),
            'title' => [
                'en' => $this->faker->sentence(),
                'ar' => $this->faker->sentence(),
            ],
            'body' => [
                'en' => $this->faker->paragraph(),
                'ar' => $this->faker->paragraph(),
            ],
            'url' => $this->faker->url(),
            'icon' => 'heroicon-o-bell',
            'type' => 'info',
            'providers' => ['database'],
            'action' => 'system',
        ];
    }
}
