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
Route::get('/', 'PostsController@create');
Route::get('/text', 'PostsController@create');
Route::get('/file', 'PostsController@file');
Route::get('/apiview', 'PostsController@apiview');
Route::get('/balm', 'PostsController@balm');
Route::get('/login', 'PostsController@create');
Route::get('/register', 'PostsController@file');
//Route::get('/posts/create', 'PostsController@create');

Route::post('/posts/show', 'PostsController@segment');
Route::post('/posts/showfile', 'PostsController@segmentfile');
// Route::get('/posts/{post}', 'PostsController@show');

//Route::get('/posts/show', 'PostsController@segment');

//Route::get('/api', 'PostsController@segmentAPI');

// router สำหรับทำการส่ง api web service
Route::post('/api', 'PostsController@segmentapi');

// router สำหรับทำการ resgister
Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/wordcloud', 'WordCloudController@index');
Route::get('/bubblechart', 'BubbleChartController@index');
Route::get('/circlepacking', 'CirclePackingController@index');
Route::get('/dendrogram', 'DendrogramController@index');
