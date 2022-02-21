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

//FRONT ROUTES
Route::get('/','DashboardController@index');
Route::get('/brand/{name}','BrandController@index');
Route::get('/generation/{name}','GenerationController@index');
Route::get('/type/{name}','TypeController@index');
Route::get('/admin/login','Auth\AuthController@Admin')->name('login');
Route::post('/auth','Auth\AuthController@Auth');
Route::get('/top','CrawlController@getTopBrand');

Route::group(['middleware' => ['auth']], function () use ($router) {
    $router->get('/admin/dashboard', 'Admin\DashboardController@index');

    //USER MANAGEMENT
    $router->get('/admin/user-list/admin', 'Admin\UserManagementController@admin');
    $router->get('/admin/user-list/user', 'Admin\UserManagementController@user');
    $router->post('/admin/user-list/store', 'Admin\UserManagementController@store');
    $router->post('/admin/user-list/delete/{id}', 'Admin\UserManagementController@delete');

    //BRAND MANAGEMENT
    $router->get('/admin/brand','Admin\BrandController@index');
    $router->post('/admin/brand/store','Admin\BrandController@store');
    $router->get('/admin/brand/delete/{id}','Admin\BrandController@delete');

    //MODEL MANAFEMENT
    $router->get('/admin/model/{id}','Admin\ModelController@index');
    $router->post('/admin/model/store','Admin\ModelController@store');
    $router->get('/admin/model/delete/{id}','Admin\ModelController@delete');

    //GENERATION MANAFEMENT
    $router->get('/admin/generation/{id}','Admin\GenerationController@index');

    //TYPE MANAFEMENT
    $router->get('/admin/type/{id}','Admin\TypeController@index');


    //CRAWL DATA
    $router->get('/admin/brand/crawl','CrawlController@crawl');


    //LOGOUT
    $router->get('/logout', 'Auth\AuthController@logout');
    
});