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

Route::get('/create/{id}', 'ArtworksController@create');


Route::post('/store', 'ArtworksController@store');
Route::get('/show/{id}/', 'ArtworksController@show');
Route::get('/artworks/{id}/edit', function(){
	if (Gate::allows('admin-only', Auth::user())) {
		return view('ArtworksController@edit');
	}else {
		abort(403);
	}
});

Route::match(['put', 'patch'],'/update/{id}', 'ArtworksController@update');
Route::match(['delete'], '/destroy/{id}', 'ArtworksController@destroy');
Route::get('/artworks/viewArtist/{id}', 'ArtworksController@viewArtist');

Auth::routes();

Route::get('/home', function(){
	if (Gate::allows('admin-only', Auth::user())) {
		return ([App\Http\Controllers\HomeController::class, 'index']);
	}else {
		abort(403);
	}
	
})->name('home');


Route::get('/artists','ArtistProfileController@index');
Route::get('/artists/create', 'ArtistProfileController@create');
Route::post('/artists/store', 'ArtistProfileController@store');
Route::get('/artists/show/{id}', 'ArtistProfileController@show');
Route::get('/artists/{id}/edit', 'ArtistProfileController@edit');
Route::patch('/artists/update/{id}', 'ArtistProfileController@update');
Route::delete('/artists/destroy/{id}', 'ArtistProfileController@destroy');



