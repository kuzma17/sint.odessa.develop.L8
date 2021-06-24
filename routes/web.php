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

Route::get('/', 'PageController@home');

Auth::routes();

Route::post('/register_client', ['as'=>'register.client', 'uses'=>'Auth\RegisterController@createClient']);

Route::post('/ulogin', 'UloginController@login');

Route::middleware('client')->prefix('user')->name('user.')->group(function (){
    Route::resource('orders', 'OrderController');
    Route::get('/order-modal', ['as'=>'order.modal', 'uses'=>'UserProfileController@profile']);

    Route::get('/', ['as'=>'profile', 'uses'=>'UserProfileController@index']);

    Route::get('/edit', ['as'=>'profile.edit', 'uses'=>'UserProfileController@edit']);
    Route::post('/update', ['as'=>'profile.update', 'uses'=>'UserProfileController@update']);
    Route::get('/avatar', ['as'=>'avatar.edit', 'uses'=>'UserProfileController@avatar']);
    Route::post('/avatar', ['as'=>'avatar.save', 'uses'=>'UserProfileController@avatar']);
    Route::get('/avatar/delete', ['as'=>'avatar.delete', 'uses'=>'UserProfileController@dell_avatar']);
    Route::get('/password', ['as'=>'password.edit', 'uses'=>'UserProfileController@edit_password']);
    Route::post('/password', ['as'=>'password.save', 'uses'=>'UserProfileController@edit_password']);
});


Route::get('/home', ['as'=>'home', 'uses'=>'PageController@home']);
Route::get('/contacts', ['as'=>'contacts', 'uses'=>'PageController@contacts']);
Route::get('/mail', ['as'=>'mail', 'uses'=>'PageController@mail']);
Route::post('/mail', ['as'=>'send.mail', 'uses'=>'PageController@send_mail']);
Route::get('/stock', ['as'=>'stock.list', 'uses'=>'StockController@listStock']);
Route::get('/stock/{id}', ['as'=>'stock', 'uses'=>'StockController@stock']);
Route::get('/news', ['as'=>'news', 'uses'=>'NewsController@index']);
Route::get('/news/{id}', ['as'=>'news_id', 'uses'=>'NewsController@news']);

Route::post('upload-image', ['as'=>'upload_image', 'uses'=>'FileUploadController@uploader']);

Route::post('/search', ['as'=>'search', 'uses'=>'SearchController@search']);
Route::get('/search', ['as'=>'search.home', function(){ return redirect(url('/'));}]);

Route::get('/{url}', ['as'=>'page', 'uses'=>'PageController@page']);



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
