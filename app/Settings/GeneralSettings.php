<?php

namespace App\Settings;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Tallmancode\TendrSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;

    public string $test;


    public static function group(): string
    {
        return 'general';
    }

    public static function modelType(): string
    {
        return Company::class;
    }

    public static function modelId(): string
    {
        return Auth::user()->company->id;
    }


}
