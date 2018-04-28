<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

// ユーザ登録
Route::get('signup', 'Auth\AuthController@getRegister')->name('signup.get');
Route::post('signup', 'Auth\AuthController@postRegister')->name('signup.post');

// ログイン認証
Route::get('login', 'Auth\AuthController@getLogin')->name('login.get');
Route::post('login', 'Auth\AuthController@postLogin')->name('login.post');
Route::get('logout', 'Auth\AuthController@getLogout')->name('logout.get');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
    Route::group(['prefix' => 'users/{id}'], function () { 
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
        
    });

    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);
});

// http://36700cb7fb2048e0a69a7053b7d98cff.vfs.cloud9.us-east-2.amazonaws.com/microposts/1/favorite
// http://your-domain.com/microposts/{id}/favorite <- id = MicropostのID
Route::group(['prefix' => 'microposts/{id}'], function () { 
    Route::post('favorite', 'MicropostFavoriteController@store')->name('micropost.favorite');
    Route::delete('unfavorite', 'MicropostFavoriteController@destroy')->name('micropost.unfavorite');
    Route::get('favorites', 'UsersController@favorites')->name('users.favorites');
});
