<?php

namespace Controllers;

use Model\Project;
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
    public static function profile(Router $router) {
        session_start();
        isAuth();
        $router->render('dashboard/profile', [
            'title' => 'Profile'
        ]);
    }
}