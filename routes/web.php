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
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});

Route::get('/project_get_with_definitions', 'Trident\ProjectController@getWithDefinitions');
Route::get('/project_get_with_definitions_entities', 'Trident\ProjectController@getWithDefinitionsEntities');
Route::get('/project_make/{id}', 'Trident\ProjectController@make');
Route::get('/definition_get/{id}', 'Trident\DefinitionController@get');
Route::get('/definition_get_by_entity_id/{id}', 'Trident\DefinitionController@getByEntityId');
Route::get('/definition_get_with_project', 'Trident\DefinitionController@getWithProject');
Route::get('/definition_get_database_tables/{id}', 'Trident\DefinitionController@getDatabaseTables');
Route::get('/entity_generate/{id}', 'Trident\EntityController@generate');
Route::get('/entity_update_schemas/{id}', 'Trident\EntityController@updateResource');
Route::get('/view_generate/{id}', 'Trident\ViewController@generate');
Route::get('/test_generate/{id}', 'Trident\TestController@generate');


Route::get('/{any}', 'SpaController@index')->where('any', '.*');