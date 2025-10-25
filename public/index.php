<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use MVC\Router;
$router = new Router();

// LOG IN, SIGN UP, FORGET AND RESET PASSWORD

// GETS
$router->get('/', [LoginController::class, 'login']);
$router->get('/signup', [LoginController::class, 'signup']);
$router->get('/logout', [LoginController::class, 'logout']);
$router->get('/forget', [LoginController::class, 'forget']);
$router->get('/reset', [LoginController::class, 'reset']);
$router->get('/confirmation', [LoginController::class, 'confirmation']);
$router->get('/welcome', [LoginController::class, 'welcome']);

// POSTS
$router->post('/', [LoginController::class, 'login']);
$router->post('/signup', [LoginController::class, 'signup']);
$router->post('/forget', [LoginController::class, 'forget']);
$router->post('/reset', [LoginController::class, 'reset']);

$router->verifyRoutes();