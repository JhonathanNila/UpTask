<?php

namespace Controllers;

use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
        $router->render('auth/login', [
            'title' => 'Login'
        ]);
    }
    public static function logout() {
        echo "From logout";
        
    }
    public static function signup(Router $router) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
        $router->render('auth/signup', [
            'title' => 'SignUp'
        ]);
    }
    public static function forgot(Router $router) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
        $router->render('auth/forgot', [
            'title' => 'Forgot Password'
        ]);
    }
    public static function reset(Router $router) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
        $router->render('auth/reset', [
            'title' => 'Set a new Password'
        ]);
    }
    public static function confirmation(Router $router) {
        $router->render('auth/confirmation', [
            'title' => 'Account Confirmation'
        ]);
    }
    public static function welcome(Router $router) {
        $router->render('auth/welcome', [
            'title' => 'Welcome!'
        ]);
    }
}