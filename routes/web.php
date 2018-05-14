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

// Route::get('/tasks', function () {
// 	$tasks = DB::table('tasks')->get();
// 	//return $tasks;
//     return view('tasks.index', compact('tasks'));
// });

// Route::get('/tasks/{task}', function ($id) {

// 	$task = DB::table('tasks')->find($id);
// 	//return $tasks;
//     return view('tasks.show', compact('task'));
// });
Route::get('/', 'PostsController@modal');
Route::get('/text', 'PostsController@create');
Route::get('/file', 'PostsController@file');
Route::get('/apiview', 'PostsController@apiview');
Route::get('/allvis', 'PostsController@allvis');
Route::get('/modal', 'PostsController@modal');
// Route::get('/login', 'PostsController@create');
// Route::get('/register', 'PostsController@file');
//Route::get('/posts/create', 'PostsController@create');

Route::post('/posts/show', 'PostsController@segment');
Route::post('/posts/showfile', 'PostsController@segmentfile');
// Route::get('/posts/{post}', 'PostsController@show');

//Route::get('/posts/show', 'PostsController@segment');

//Route::get('/api', 'PostsController@segmentAPI');

// router สำหรับทำการส่ง api web service
Route::post('/api', 'PostsController@segmentapi');

Route::post('/apizip', 'PostsController@apizipfile');

// router สำหรับทำการ resgister
Auth::routes();

Route::get('/home', 'PostsController@modal');

Route::post('/modal/vistext', 'ModalController@process');

Route::post('/modal/visfile', 'ModalController@processfile');

Route::get('/wordcloud', 'WordCloudController@index');
Route::post('/wordcloud/process', 'WordCloudController@process');

Route::get('/sentencetree', 'SentenceTreeController@index');
Route::post('/sentencetree/process', 'SentenceTreeController@process');
Route::post('/sentencetree/processfile', 'SentenceTreeController@processfile');

Route::get('/bubblechart', 'BubbleChartController@index');
Route::post('/bubblechart/process', 'BubbleChartController@process');

Route::get('/circlepacking', 'CirclePackingController@index');
Route::post('/circlepacking/process', 'CirclePackingController@process');

Route::get('/dendrogram', 'DendrogramController@index');
Route::post('/dendrogram/processfile', 'DendrogramController@processfile');

Route::post('/columnchart/processfile', 'DendrogramController@columnchart');
