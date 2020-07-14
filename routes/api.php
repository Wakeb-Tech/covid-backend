<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('cases', 'CovidController@getAll');
Route::post('cases/country', 'CovidController@getCountryByName');
Route::get('world/statics', 'CovidController@getworldState');
Route::get('world/affected', 'CovidController@affectedCountries');
Route::get('world/top_cases', 'CovidController@topFiveCases');
Route::get('arabs/top_cases', 'CovidController@topFiveArab');
Route::get('arabs/statics', 'CovidController@arabStates');
Route::get('world/top_recovered', 'CovidController@topWorldRecovered');
Route::get('arabs/top_recovered', 'CovidController@topArabRecovered');
