<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');

// Localization
Route::get('/js/lang.js', function () {
    $strings = Cache::rememberForever('lang.js', function () {
        $lang = config('app.locale');

        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');

Auth::routes();

Route::name('board.')->group(function() {
    Route::prefix('board')->group(function() {
        Route::get('/{itemType?}', 'BoardController@index')->name('index')->middleware('auth');

        Route::get('test', 'BoardController@test')->name('test');
    });
});

Route::name('item.')->group(function() {
   Route::prefix('item')->group(function() {
       Route::get('/view/{item}', 'ItemController@view')->name('view')->middleware('auth');
       Route::get('/edit/{item}', 'ItemController@edit')->name('edit')->middleware('auth');
       Route::post('/save/{item?}', 'ItemController@save')->name('save')->middleware('auth');
       Route::get('/new/{itemType}', 'ItemController@newItem')->name('new')->middleware('auth');
       Route::get('/delete/{item}', 'ItemController@delete')->name('delete')->middleware('auth');
   });
});

Route::name('user.')->group(function() {
    Route::prefix('user')->group(function() {
        Route::get('/settings', 'UserController@settings')
            ->name('settings')->middleware('auth');
        Route::post('/settings/password', 'UserController@password')
            ->name('settings.password')->middleware('auth');
        Route::post('/settings/{property}','UserController@changeProperty')
            ->name('settings.property')->middleware('auth');
    });
});

Route::name('data.')->group(function() {
    Route::prefix('data')->group(function() {
        Route::get('/itemtype', 'DataSourceController@getItemTypes')->name('itemtype')->middleware('auth');
    });
});
