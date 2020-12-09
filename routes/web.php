<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['domain' => env('APP_DOMAIN'), 'middleware' => ['web', 'guest']], function () {
    Route::get('/', function () {
        return view('frontend.index');
    })->name('home');
});

Route::group(['domain' => 'app.'.env('APP_DOMAIN'), ], function () {
    Route::group(['middleware' => ['web', 'auth']], function () {
        Route::view('/{any}', 'app.index')->where('any', '^(?!api).*$')->name('backend');
    });
});

Auth::routes();



//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
