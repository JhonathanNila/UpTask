<?php

namespace Controllers;

use Classes\Email;
use Model\User;
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
        $user = new User;
        $alerts = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sync($_POST);
            $alerts = $user->validateNewAccount();
            if(empty($alerts)) {
                $userExists = User::where('EMAIL', $user->EMAIL);
                if($userExists) {
                    User::setAlert('error', 'An account with that email already exists');
                    $alerts = User::getAlerts();
                } else {
                    $user->hashPassword();
                    unset($user->PASSWORD2);
                    $user->generateToken();
                    $result = $user->save();
                    $email = new Email($user->EMAIL, $user->NAME, $user->TOKEN);
                        $email->sentConfirmation();
                    if($result) {
                        header('Location: /confirmation');
                    }
                }
            }
        }
        $router->render('auth/signup', [
            'title' => 'SignUp',
            'user' => $user,
            'alerts' => $alerts
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
        $token = s($_GET['token']);
        if(!$token) {
            header('Location: /');
        }
        $user = User::where('TOKEN', $token);
        if(empty($user)) {
            User::setAlert('error', 'Invalid Token');
        } else {
            $user->CONFIRMED = 1;
            unset($user->PASSWORD2);
            $user->TOKEN = '';
            $user->save();
        }
        $alerts = User::getAlerts();
        $router->render('auth/welcome', [
            'title' => 'Account Confirmed',
            'alerts' => $alerts
        ]);
    }
}