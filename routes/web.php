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

Route::get('/', 'MicropostsController@index');

// ユーザ登録 $this->middleware('guest');つまり、signup表示はguestのみ
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// 認証  $this->middleware('guest')->except('logout');つまり、login表示はguestのみ。logout表示はauthのみ
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

//authユーザーのみアクセス可。
Route::group(['middleware' => ['auth']], function () {
    
    Route::group(['prefix' => 'users/{id}'], function () {
        //フォロー機能
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
        
        //お気に入り機能-view一覧
        Route::get('favorites','UsersController@favorites')->name('users.favorites');
        
    });
    //お気に入り機能-2
    Route::group(['prefix' => 'microposts/{id}'],function(){
        Route::post('favorite','FavoritesController@store')->name('favorites.favorite');
        Route::delete('unfavorite','FavoritesController@destroy')->name('favorites.unfavorite');
    });
    
    //ユーザーモデル@index@show
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
    //マイクロポストモデル@store@destroy
    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);
    
});