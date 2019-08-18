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

Route::get('/default', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/definition_get/{id}', 'Trident\DefinitionController@get');
Route::get('/definition_get_database_tables/{id}', 'Trident\DefinitionController@getDatabaseTables');
Route::get('/entity_generate/{id}', 'Trident\EntityController@generate');

Route::get('/{any}', 'SpaController@index')->where('any', '.*');