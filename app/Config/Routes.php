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

$routes->get('/users/register', "Register::index");
$routes->post('/users/register', "Register::store");
$routes->get('/users/login', "LoginController::index");
$routes->post('/users/login', "LoginController::postlogin");
