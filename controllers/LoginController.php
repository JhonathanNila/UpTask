<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $alerts = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST);
            $alerts = $user->validateLogin();
            if(empty($alerts)) {
                $user = User::where('EMAIL', $user->EMAIL);
                if(!$user || !$user->CONFIRMED) {
                    User::setAlert('error', 'The user does not exist or the account is not validated');
                } else {
                    if(password_verify($_POST['PASSWORD'], $user->PASSWORD)) {
                        session_start();
                        $_SESSION['ID'] = $user->ID;
                        $_SESSION['NAME'] = $user->NAME;
                        $_SESSION['EMAIL'] = $user->EMAIL;
                        $_SESSION['LOGGED_IN'] = true;
                        header('Location: /dashboard');
                    } else {
                        User::setAlert('error', 'Incorrect Email or Password');
                    }
                }
            }
        }
        $alerts = User::getAlerts();
        $router->render('auth/login', [
            'title' => 'Login',
            'alerts' => $alerts
        ]);
    }
    public static function logout() {
        session_start();
        $_SESSION = [];
        header('Location: /');
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
        $alerts = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST);
            $alerts = $user->validateEmail();
            if(empty($alerts)) {
                $user = User::where('EMAIL', $user->EMAIL);
                if($user && $user->CONFIRMED) {
                    $user->generateToken();
                    unset($user->PASSWORD2);
                    $user->save();
                    $email = new Email($user->EMAIL, $user->NAME, $user->TOKEN);
                    $email->sentInstructions();
                    User::setAlert('success', 'We’ve sent the instructions to reset your Password');
                } else {
                    User::setAlert('error', 'The user does not exist or the account is not validated');
                }
            }
        }
        $alerts = User::getAlerts();
        $router->render('auth/forgot', [
            'title' => 'Forgot Password',
            'alerts' => $alerts
        ]);
    }
    public static function reset(Router $router) {
        $token = s($_GET['token']);
        $show =  true;
        $alerts = [];
        if(!$token) {
            header('Location: /');
        }
        $user = User::where('TOKEN', $token);
        if(empty($user)) {
            User::setAlert('error', 'Invalid Token');
            $show = false;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sync($_POST);
            $alerts = $user->validatePassword();
            if(empty($alerts)) {
                $user->hashPassword();
                unset($user->PASSWORD2);
                $user->TOKEN = '';
                $result = $user->save();
                if($result) {
                    header('Location: /');
                }
            }
        }
        $alerts = User::getAlerts();
        $router->render('auth/reset', [
            'title' => 'Set a new Password',
            'alerts' => $alerts,
            'show' => $show
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