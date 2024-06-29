<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace("App\Controllers");
$routes->setDefaultMethod("index");
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);


$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('/start', 'Home::quiz', ['filter' => 'auth']);
$routes->get('/informasi', 'Home::informasi', ['filter' => 'auth']);


$routes->get('/auth/login', "Auth::login");
$routes->post('/auth/postlogin', 'Auth::postLogin');
$routes->get('/auth/register', "Auth::register");
$routes->post('/auth/register', 'Auth::postRegister');
$routes->post('/auth/logout', 'Auth::logout');
$routes->get('/account/list', 'Auth::listAccounts', ['filter' => 'auth']);
$routes->get('/account/edit', 'Auth::editAccount', ['filter' => 'auth']);
$routes->post('/account/postedit', 'Auth::postEditAccount', ['filter' => 'auth']);
$routes->post('/account/delete', 'Auth::deleteAccount', ['filter' => 'auth']);
$routes->get('/error_page', "Home::errorPage");
$routes->get("/admin/create-quiz", "Quizioner::adminCreate", ['filter' => 'auth']);
$routes->get("/admin/create-formula", "Quizioner::adminCreateFormula", ['filter' => 'auth']);
$routes->post('/admin/post-create-formula', "Quizioner::adminPostFormula", ['filter' => 'auth']);
$routes->get("/admin/list-formula", "Quizioner::adminListFormula", ['filter' => 'auth']);
$routes->get("/admin/edit-formula", "Quizioner::adminEditFormula", ['filter' => 'auth']);
$routes->post("/admin/delete-formula", "Quizioner::adminDeleteFormula", ['filter' => 'auth']);
$routes->post("/admin/post-edit-formula", "Quizioner::adminPostEditFormula");
$routes->get('/admin/list-quiz', "Quizioner::adminListQuiz", ['filter' => 'auth']);
$routes->get("/admin/list-rating", "Quizioner::listRating", ['filter' => 'auth']);

$routes->get("/question/edit", "Quizioner::editQuestion", ['filter' => 'auth']);

$routes->post('/question/post-edit', "Quizioner::postEditQuestion", ['filter' => 'auth']);
$routes->post('/question/delete', "Quizioner::deleteQuestion", ['filter' => 'auth']);
$routes->get("/question/hasil", "Quizioner::postHasilQuestion", ['filter' => 'auth']);
$routes->post('/post/rating', "Quizioner::postRatingQuestion", ['filter' => 'auth']);



// new API
$routes->add('/api/test/register', "API\User::register");
$routes->get('/test/authorize', 'Auth::listAccounts', ['filter' => 'auth']);

$routes->add('/api/test/jwt', "API\User::testJWT");
$routes->post('/api/test/generateToken', "API\Token::generateToken");
$routes->get('/test/get_cookie', 'Auth::test');
$routes->get('/test/set_cookie', 'Auth::setUserCookie');

$routes->get("/test", "Test::index");
$routes->post("/test/posting", "Test::testPost");
$routes->get("/test/auth", "Test::testAuth", ['filter' => 'auth']);
$routes->get('/test/admin', "Home::index", ['filter' => 'admin']);
