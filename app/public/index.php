<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

require __DIR__ . '/../vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();

$router->setNamespace('Controllers');

// routes for the products endpoint
$router->get('/passwords', 'PasswordController@getAll');
$router->get('/password/(\d+)', 'PasswordController@getOne');
$router->post('/password', 'PasswordController@create');
$router->put('/password/(\d+)', 'PasswordController@update');
$router->delete('/password/(\d+)', 'PasswordController@delete');

$router->post('/users/login', 'UserController@login');
$router->post('/users/signup', 'UserController@signup');


// Run it!
$router->run();