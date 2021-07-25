<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'ArtworksController@index');
Route::get('/create', 'ArtworksController@create');
Route::post('/store', 'ArtworksController@store');
Route::get('/show/{id}/', 'ArtworksController@show');
Route::get('/artworks/{id}/edit', 'ArtworksController@edit');
Route::match(['put', 'patch'],'/update/{id}', 'ArtworksController@update');
Route::match(['delete'], '/destroy/{id}', 'ArtworksController@destroy');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
