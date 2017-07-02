<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    
    Route::auth();
    
    Route::get('/home', 'HomeController@index');
    Route::get('/home/websockets', 'HomeController@websockets');
    
    Route::get('/search', 'GameController@search');
    
    Route::post('/create', ['as' => 'create', 'uses' => 'GameController@create']);
    Route::get('/game/{gameId}', ['as' => 'game', 'uses' => 'GameController@game']);
    Route::get('/ajax/get/token', 'Ajax\TokenController@sendToken');
    Route::post('/ajax/send/turn', 'Ajax\TurnController@turn');
});

/*
 * Admin route
 */
Route::group(['middleware' => ['web', 'admin']], function () {
    
    Route::get('/admin/home', 'Admin\AdminController@index');
    
});


/*
 * For test purposes only, remove
 */
Route::get('/init-event', function () {
    $data = 'server message;)';
    \App\Sockets\PushServerSocket::setDataToServer($data);
});
