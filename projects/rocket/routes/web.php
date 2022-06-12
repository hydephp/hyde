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

$router->get('/', 'DashboardController@index');

$router->get('/version', function () use ($router) {
    return $router->app->version();
});

$router->get('/debug', 'DebugController');
$router->get('/manual', function () {
    return view('manual');
});

$router->get('/_posts/{slug}', 'PostController@show');
$router->post('/_posts/{slug}', 'PostController@update');
$router->get('/create-post', 'PostController@create');
$router->post('/create-post', 'PostController@store');


$router->post('/fileapi/open', 'FilesystemController@open');
$router->get('/open/_site', 'RealtimeCompiler@render');
$router->get('/render/markdown', 'RealtimeCompiler@markdown');

$router->get('/api/ping-realtime-compiler', 'ApiController@pingRealtimeCompiler');
