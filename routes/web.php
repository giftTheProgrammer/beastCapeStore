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
Route::get('/playerLoad/{id}/', 'ArtworksController@playerLoad');
Route::get('/artworks/{id}/edit', function(){
	if (Gate::allows('admin-only', Auth::user())) {
		return view('ArtworksController@edit');
	}else {
		abort(403);
	}
});

Route::match(['put', 'patch'],'/update/{id}', 'ArtworksController@update');
Route::match(['put', 'patch'], '{id}/approve', 'ArtworksController@approve');
Route::match(['delete'], '/destroy/{id}', 'ArtworksController@destroy');
Route::get('/artworks/viewArtist/{id}', 'ArtworksController@viewArtist');
Route::get('/artworks/music', 'ArtworksController@musicView')->name('artworks.music');
Route::get('/cart', function(){
	// if (Gate::allows('buyers-only', Auth::user()) {
		return view('trolley');
	// }else {
	// 	abort(403);
	// }
})->name('cart');

Route::get('add-to-cart/{id}', 'ArtworksController@addToCart')->name('add.to.cart');
Route::put('update-cart', 'ArtworksController@updateCart')->name('update.cart');
Route::delete('remove-from-cart', 'ArtworksController@remove')->name('remove.from.cart');
Route::get('/checkout', 'ArtworksController@checkout')->name('checkout');
Route::get('/success', function(){ return view('success'); })->name('success');
Route::get('/notify', function(){ return view('notify'); })->name('notify');
Route::get('/cancel', function(){ return view('cancel'); })->name('cancel');

Auth::routes(['verify' => true]);

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

Route::get('/managers', 'ManagersController@index');
Route::get('/managers/{id}/setStatus', 'ManagersController@edit');


