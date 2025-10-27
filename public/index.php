<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use MVC\Router;
$router = new Router();

// LOG IN, SIGN UP, FORGET AND RESET PASSWORD

// GETS
$router->get('/', [LoginController::class, 'login']);
$router->get('/signup', [LoginController::class, 'signup']);
$router->get('/logout', [LoginController::class, 'logout']);
$router->get('/forgot', [LoginController::class, 'forgot']);
$router->get('/reset', [LoginController::class, 'reset']);
$router->get('/confirmation', [LoginController::class, 'confirmation']);
$router->get('/welcome', [LoginController::class, 'welcome']);

// POSTS
$router->post('/', [LoginController::class, 'login']);
$router->post('/signup', [LoginController::class, 'signup']);
$router->post('/forgot', [LoginController::class, 'forgot']);
$router->post('/reset', [LoginController::class, 'reset']);

// DASHBOARD AND PROJECTS ZONE

// GETS
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/new-project', [DashboardController::class, 'newProject']);
$router->get('/profile', [DashboardController::class, 'profile']);

// POSTS
$router->post('/new-project', [DashboardController::class, 'newProject']);

$router->verifyRoutes();