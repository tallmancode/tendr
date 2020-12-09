<?php

namespace App\Settings;

use App\Settings\Settings;
use Spatie\LaravelSettings\Settings as LaravelSettingsSettings;

class GeneralSettings extends LaravelSettingsSettings
{
    public string $site_name;

    public static function group(): string
    {
        return 'general';
    }
}
