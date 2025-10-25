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
    public static function forgot() {
        echo "From forget password";
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
    }
    public static function reset() {
        echo "From reset password";
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
    }
    public static function confirmation() {
        echo "From confirmation password";
    }
    public static function welcome() {
        echo "From welcome password";
    }
}