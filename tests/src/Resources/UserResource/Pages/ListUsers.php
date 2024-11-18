<?php

namespace TomatoPHP\FilamentAlerts\Tests\Resources\UserResource\Pages;

use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentAlerts\Tests\Resources\UserResource;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
}
