<?php

namespace App\Http\Controllers;

use App\Settings\GeneralSettings;
use App\Settings\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(GeneralSettings $settings, Request $request)
    {
        //dump($request);
        //dump($request->input('name'));
        $settings->site_name = $request->site_name;

        $settings->save();
    }
}
