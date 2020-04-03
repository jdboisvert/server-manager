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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});


//Public API route group
$router->group(['prefix' => 'api'], function () use ($router) {
   // Matches /api/register
   $router->post('register', 'AuthController@register');
   
   // Matches /api/login
   $router->post('login', 'AuthController@login');

});

//Private API route group (must provide token)
$router->group(
    ['prefix' => 'api', 'middleware' => 'jwt.auth'], 
    function() use ($router) {
        $router->get('list', 'ServerConnectionController@getAllServerConnections');
        
        $router->post('create', 'ServerConnectionController@createServerConnection');
        $router->get('server/details/{id}', 'ServerConnectionController@readServerConnection');
        $router->post('server/update/{id}', 'ServerConnectionController@updateServerConnection');
        $router->post('server/delete/{id}', 'ServerConnectionController@deleteServerConnection');
        
    }
);