<?php

namespace Tallmancode\TendrSettings\Events;

use Tallmancode\TendrSettings\Settings;

class SettingsLoaded
{
    public Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }
}
