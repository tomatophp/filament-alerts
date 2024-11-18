<?php

namespace TomatoPHP\FilamentAlerts\Tests;

use TomatoPHP\FilamentAlerts\Filament\Pages\EmailSettingsPage;
use TomatoPHP\FilamentAlerts\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('can render Email Settings Page', function () {
    get(EmailSettingsPage::getUrl())->assertSuccessful();
});
