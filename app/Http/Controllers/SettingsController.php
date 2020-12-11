<?php

namespace App\Http\Controllers;

use App\Settings\GeneralSettings;
use App\Settings\Settings;
use Illuminate\Http\Request;
use Tallmancode\TendrSettings\Settings as TendrSettingsSettings;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(GeneralSettings $settings, Request $request)
    {
        $settings->site_name = $request->site_name;
        $settings->save();

        return $settings->get();
    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(GeneralSettings $settings)
    {
        return $settings->get();
    }
}
