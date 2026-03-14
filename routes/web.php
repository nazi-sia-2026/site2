<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
// unsecure route
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/users2', ['uses' => 'UserController@getUsers']);
});

$router->get('/users2', 'UserController@index'); 
$router->post('/users2', 'UserController@add');
$router->get('/users2/{id}', 'UserController@show');
$router->put('/users2/{id}','UserController@update');
$router->patch('/users2/{id}','UserController@update');
$router->delete('/users2/{id}','UserController@delete');

$router->get('/test-db', function() {
    try {
        $results = app('db')->select("SELECT * FROM users");
        return response()->json([
            'status' => 'Connected!',
            'count' => count($results),
            'data' => $results
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'Error',
            'message' => $e->getMessage()
        ], 500);
    }
});