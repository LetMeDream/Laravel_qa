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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/** Resourceful Route for questions */
Route::resource('questions', 'QuestionsController')->except('show');
Route::get('questions/{slug}', 'QuestionsController@show')->name('questions.show');

/** Resourceful Route for answers */
Route::resource('questions.answers', 'AnswersController')->only(['store', 'destroy', 'update', 'edit']);
/* Route::post('questions/{question}/answers', 'AnswerController@store')->name('answers.store'); */
