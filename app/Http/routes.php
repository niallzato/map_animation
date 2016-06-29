<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('map');
});

Route::get('/radius', function () {
    return view('radius');
});

Route::get('/d3', function () {
    return view('d3');
});

Route::get('/d3/map', function () {
    return view('d3-map');
});

Route::post('/data', 'Controller@statedata');

//Route::post('/text', 'Controller@postForm');
