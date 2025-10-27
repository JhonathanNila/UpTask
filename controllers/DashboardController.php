<?php

namespace Controllers;

use MVC\Router;

class DashboardController {
    public static function index(Router $router) {
        session_start();
        isAuth();
        $router->render('dashboard/index', [
            'title' => 'Dashboard'
        ]);
    }
    public static function newProject(Router $router) {
        session_start();
        isAuth();
        $router->render('dashboard/new-project', [
            'title' => 'New Project'
        ]);
    }
    public static function profile(Router $router) {
        session_start();
        isAuth();
        $router->render('dashboard/profile', [
            'title' => 'Profile'
        ]);
    }
}