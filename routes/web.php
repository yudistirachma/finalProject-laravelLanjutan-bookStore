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

// <<<<<<< HEAD
// // Route::get('/{any?}', function () {
// //     return view('app');
// // });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::view('/checkout','book.pay');

Route::view('/chat','chat.chat');

//Route::view('/order','book.OrderBook');
Auth::routes();

Route::get('/', 'BookController@index');
Route::get('/create', 'BookController@create');
Route::post('/', 'BookController@store');
Route::get('/list', 'BookController@list');
Route::get('/product-list', 'BookController@productList');
Route::get('{book}', 'BookController@show');
Route::delete('{book}', 'BookController@destroy');
Route::get('{book}/edit', 'BookController@edit');

Route::view('/chat','chat.chat')->middleware('auth');

Route::get('/chat/all-chats','ChatController@all_chats');
Route::post('/chat/store','ChatController@store');
