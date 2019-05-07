<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/auth/new', 'AuthController@authorizeU');
$router->get('/profile', 'MainController@profile');

$router->group(['namespace' => 'Gameplay', 'prefix' => 'game'], function() use ($router) {
    $router->group(['namespace' => 'Police', 'prefix' => 'p'], function() use ($router) {
        $router->get('/state', 'PoliceController@state');
        $router->patch('/callsign', 'PoliceController@setCallsign');
        $router->patch('/status', 'PoliceController@setStatus');
        $router->post('/detach', 'PoliceController@detach');
    });
    $router->group(['namespace' => 'Dispatch', 'prefix' => 'd'], function() use ($router) {
        $router->patch('/status/{user}', 'DispatchController@setStatus');
        $router->post('/call', 'DispatchController@newCall');
        $router->patch('/call/{call}', 'DispatchController@updateCall');
        $router->post('/call/{call}/timeline', 'DispatchController@updateTimeline');
        $router->delete('/call/{call}', 'DispatchController@archiveCall');
        $router->post('/call/{call}/attach/{unit}', 'DispatchController@assignCall');
        $router->post('/unit/{unit}/detach', 'DispatchController@detach');
    });
    $router->group(['namespace' => 'Universal', 'prefix' => 'u'], function() use ($router) {
        $router->get('/plate/{plate}', 'UniversalController@plate');
        $router->get('/id', 'UniversalController@lookupId');
        $router->get('/id/{id}', 'UniversalController@IdDetail');
    });
});