<?php

namespace Controllers;

use Model\Project;
use Model\User;
use MVC\Router;

class DashboardController {
    public static function index(Router $router) {
        session_start();
        isAuth();
        $id = $_SESSION['ID'];
        $projects = Project::belongsTo('OWNER_ID', $id);
        $router->render('dashboard/index', [
            'title' => 'Dashboard',
            'projects' => $projects
        ]);
    }
    public static function newProject(Router $router) {
        session_start();
        isAuth();
        $alerts = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project = new Project($_POST);
            $alerts = $project->validateProject();
            if(empty($alerts)) {
                $hash = md5(uniqid());
                $project->URL = $hash;
                $project->OWNER_ID = $_SESSION['ID'];
                $project->save();
                header('Location: /project?id=' . $project->URL);
            }
        }
        $router->render('dashboard/new-project', [
            'title' => 'New Project',
            'alerts' => $alerts
        ]);
    }
    public static function project(Router $router) {
        session_start();
        isAuth();
        $token = $_GET['id'];
        $alerts = [];
        if(!$token) {
            header('Location: /dashboard');
        }
        $project = Project::where('URL', $token);
        if($project->OWNER_ID !== $_SESSION['ID']) {
            header('Location: /dashboard');
        }
        $router->render('dashboard/project', [
            'title' => $project->PROJECT,
            'alerts' => $alerts
        ]);
    }
    public static function profile(Router $router) {
        session_start();
        isAuth();
        $alerts = [];
        $user = User::find($_SESSION['ID']);
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sync($_POST);
            $alerts = $user->validateProfile();
            if(empty($alerts)) {
                $userExists = User::where('EMAIL', $user->EMAIL);
                if($userExists && $userExists->ID !== $user->ID) {
                    User::setAlert('error', 'Email registered with another user');
                } else {
                    $user->save();
                    User::setAlert('success', 'Changes Saved Correctly');
                    $_SESSION['NAME'] = $user->NAME;
                }
            }
            $alerts = $user->getAlerts();
        }
        $router->render('dashboard/profile', [
            'title' => 'Profile',
            'user' => $user,
            'alerts' => $alerts
        ]);
    }
    public static function changePassword(Router $router) {
        session_start();
        $alerts = [];
        isAuth();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = User::find($_SESSION['ID']);
            $user->sync($_POST);
            $alerts = $user->newPassword();
            if(empty($alerts)) {
                $result = $user->passwordVerify();
                if($result) {
                    $user->PASSWORD = $user->PASSWORD_NEW;
                    unset($user->PASSWORD2);
                    unset($user->PASSWORD_CURRENT);
                    unset($user->PASSWORD_NEW);
                    $user->hashPassword();
                    $result = $user->save();
                    if($result) {
                        User::setAlert('success', 'New password set successfully');
                    }
                } else {
                    User::setAlert('error', 'Incorrect Current Password');
                }
            }
            $alerts = $user->getAlerts();
        }
        $router->render('dashboard/changePassword', [
            'title' => 'Change Password',
            'alerts' => $alerts
        ]);
    }
}