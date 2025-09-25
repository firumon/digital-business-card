<?php

use Illuminate\Support\Facades\Route;
use Firumon\DigitalBusinessCard\Controllers\RouteController;
use Firumon\DigitalBusinessCard\Controllers\IndividualController;
use Firumon\DigitalBusinessCard\Controllers\SettingController;
use Firumon\DigitalBusinessCard\Controllers\AuthController;
use \Firumon\DigitalBusinessCard\Middleware\HasRole;

const APP_ROLES = ['Developer','Administrator','Reseller','Manager','Individual'];

Route::middleware(['web'])->group(function(){
    Route::middleware(['auth'])->group(function(){
        Route::view('{role}/{any?}','dbc::User')->whereIn('role',APP_ROLES)->where('any','.*');
        Route::group([
            'prefix' => '/Developer',
            'middleware' => HasRole::class . ":Developer",
        ],function(){
            Route::group(['prefix' => 'api'],function(){
                Route::group([
                    'prefix' => '/property',
                    'controller' => \Firumon\DigitalBusinessCard\Controllers\PropertyController::class,
                ],function(){
                    Route::post('/save','save');
                    Route::post('/delete','delete');
                });
                Route::group([
                    'prefix' => 'layout',
                    'controller' => \Firumon\DigitalBusinessCard\Controllers\LayoutController::class
                ],function(){
                    Route::post('/save','save');
                    Route::post('/delete','delete');
                    Route::post('/update','update');
                    Route::post('/property','addProperty');
                    Route::post('/property_update','updateProperty');
                    Route::post('/property_delete','deleteProperty');
                    Route::post('/users_update','updateUsers');
                });
            });
        });
        Route::group([
            'prefix' => '/Administrator',
            'middleware' => HasRole::class . ":Administrator",
        ],function(){
            Route::group(['prefix' => 'api'],function(){
                Route::group([
                    'prefix' => '/company',
                    'controller' => \Firumon\DigitalBusinessCard\Controllers\CompanyController::class,
                ],function(){
                    Route::post('/','all');
                    Route::post('/save','save');
                    Route::post('/delete','delete');
                });
                Route::group([
                    'prefix' => 'user',
                    'controller' => \Firumon\DigitalBusinessCard\Controllers\UserController::class,
                ],function(){
                    Route::post('resellers','adminResellers');
                });

            });

        });
        Route::get('{item}',[RouteController::class,'company_admin'])->whereIn('item',['individuals','settings']);
        Route::post('individual',[IndividualController::class,'individual'])->name('company_admin');
        Route::post('setting',[SettingController::class,'setting']);
        Route::get('logout',[AuthController::class,'logout'])->name('logout');
        Route::get('/script/user/{user_id}/data.js',[AuthController::class,'user']);
        Route::group([
            'prefix' => '{role}',
        ],function(){
            Route::group(['prefix' => 'api'],function(){
                Route::group([
                    'prefix' => 'profile',
                    'controller' => \Firumon\DigitalBusinessCard\Controllers\UserController::class,
                ],function(){
                    Route::post('update','profileUpdate');
                    Route::post('password','profilePasswordUpdate');
                });
                Route::group([
                    'prefix' => 'user',
                    'controller' => \Firumon\DigitalBusinessCard\Controllers\UserController::class,
                ],function(){
                    Route::post('/','getAll');
                    Route::post('add','add');
                    Route::post('update','userUpdate');
                    Route::post('password','userPasswordUpdate');
                });
                Route::group([
                    'prefix' => 'layout',
                    'controller' => \Firumon\DigitalBusinessCard\Controllers\LayoutController::class
                ],function(){
                    Route::post('/','getAllWithProperties');
                    Route::post('/users_update','updateUsers');
                });
                Route::group([
                    'prefix' => 'company',
                    'controller' => \Firumon\DigitalBusinessCard\Controllers\CompanyController::class
                ],function(){
                    Route::post('/','all');
                    Route::post('save','save');
                    Route::post('update','update');
                    Route::post('individual','addIndividual');
                    Route::post('properties','syncProperties');
                    Route::post('individual_name','updateIndividualName');
                    Route::post('individual_properties','updateIndividualProperties');
                    Route::post('user','addUser');
                    Route::post('users_sync','syncUsers');
                    Route::post('individual_user','addIndividualUser');
                    Route::post('individual_user_add','addIndividualUserLogin');
                    Route::post('individual_user_remove','removeIndividualUserLogin');
                });
                Route::group([
                    'prefix' => 'property',
                    'controller' => \Firumon\DigitalBusinessCard\Controllers\PropertyController::class
                ],function(){
                    Route::post('/','all');
                });

            });
        });
    });
    Route::get('/',[RouteController::class,'app_view_company']);
    Route::view('/login','dbc::login')->name('login');
    Route::post('/login',[AuthController::class,'login']);
    Route::get('/{code}',[RouteController::class,'app_view_individual']);
    Route::get('/script/VCardProperty.js',function(){ return response(\Firumon\DigitalBusinessCard\Models\VCardProperty::jsData(),200,["content-type" => "text/javascript"]); });
});
