<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace("App\Controllers");
$routes->setDefaultController("Login");
$routes->setDefaultMethod("index");
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);


$routes->get('/', 'Home::index', ["filter" => "auth"]);
$routes->post('/', "Home::getHasil", ["filter" => "auth"]);

$routes->get('/users/register', "Register::index",  ["filter" => "noauth"]);
$routes->post('/users/register', "Register::store",  ["filter" => "noauth"]);
$routes->get('/users/login', "LoginController::index",  ["filter" => "noauth"]);
$routes->post('/users/login', "LoginController::postlogin",  ["filter" => "noauth"]);
$routes->get("/users/logout", "LoginController::logout");
