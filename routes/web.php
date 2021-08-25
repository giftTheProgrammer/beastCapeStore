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

Route::get('/create', function(){
	if (Gate::allows('admin-only', Auth::user())) {
		return view('artworks.create');
	} else {
		abort(403);
	}
});


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

Auth::routes();

Route::get('/home', function(){
	if (Gate::allows('admin-only', Auth::user())) {
		return ([App\Http\Controllers\HomeController::class, 'index']);
	}else {
		abort(403);
	}
	
})->name('home');
