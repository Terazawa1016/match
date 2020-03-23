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

Route::get('/', function () {
    return view('top');
});

//プロフィール画面は、ユーザがログインしている状態でのみ表示させたい
//なのでここで'middleware' => 'auth'と表記し、認証済みか判定している
//Route::groupの引数で'middleware' => 'auth'と記載し、共通の処理をグループ化
//なのでここでログインした後のルートを中に書いていく
Route::group(['prefix' => 'users', 'middleware' => 'auth'], function() {
  //ここでの{id}はUserテーブルのid、後ろのコントローラーはshowメソッドを呼ぶ為
  Route::get('show/{id}', 'UserController@show')->name('users.show');

  //編集用表示ページ
  Route::get('edit/{id}','UserController@edit')->name('users.edit');
  //編集後の表示をさせる為のページ
  Route::post('update/{id}', 'UserController@update')->name('users.update');
});

Auth::routes();

Route::get('/', function() {
  return view('top');
});

Route::get('/home', 'HomeController@index')->name('home');

//マッチング処理
Route::get('/matching', 'MatchingController@index')->name('matching');

// ここでチャットに参加しているかどうかの判定をしている
Route::group(['prefix' => 'chat', 'middleware' => 'auth'], function(){
  Route::post('show', 'ChatController@show')->name('chat.show');
  Route::post('chat', 'ChatController@chat')->name('chat.chat');
});
