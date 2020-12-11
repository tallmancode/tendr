<?php

namespace Tallmancode\TendrSettings\Events;

use Tallmancode\TendrSettings\Support\SettingsPropertyDataCollection;

class LoadingSettings
{
    public string $settingsClass;

    public SettingsPropertyDataCollection $properties;

    public function __construct(string $settingsClass, SettingsPropertyDataCollection $properties)
    {
        $this->settingsClass = $settingsClass;

        $this->properties = $properties;
    }
}
