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

//Route::get('/', function () {
//    return view('welcome');
//});

// 获取小说列表
Route::get('/novels', 'NovelController@novelList');
Route::get('/novels/{book_id}', 'NovelController@novelDetail');
Route::get('/novels/{book_id}/contents', 'NovelController@novelContents');
Route::get('/novels/{book_id}/chapters', 'NovelController@novelChapters');
Route::get('/novels/{book_id}/chapters/{chapter_id}', 'NovelController@novelChapterContent');
