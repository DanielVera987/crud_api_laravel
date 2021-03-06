<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    "prefix" => "v1"
], function(){
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register', 'AuthController@register');
    Route::apiResource('post', 'PostController');
});
