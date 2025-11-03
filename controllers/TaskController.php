<?php

namespace Controllers;

use Model\Project;
use Model\Task;

class TaskController {
    public static function index() {
        session_start();
        $projectId = $_GET['id'];
        if(!$projectId) {
            header('Location: /dashboard');
        }
        $project = Project::where('URL', $projectId);
        if(!$project || $project->OWNER_ID !== $_SESSION['ID']) {
            header('Location: /404');
        }
        $tasks = Task::belongsTo('PROJECT_ID', $project->ID);

        echo json_encode(['tasks' => $tasks]);
    }
    public static function create() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $projectId = $_POST['PROJECT_ID'];
            $project = Project::where('URL', $projectId);
            if(!$project || $project->OWNER_ID !== $_SESSION['ID']) {
                $response = [
                    'type' => 'error',
                    'message' => 'There was an error adding the task'
                ];
                echo json_encode($response);
                return;
            }
            $task = new Task($_POST);
            $task->PROJECT_ID = $project->ID;
            $result = $task->save();
            $response = [
                'type' => 'success',
                'ID' => $result['ID'],
                'message' => 'Task added correctly',
                'PROJECT_ID' => $project->ID
            ];
            echo json_encode($response);
        }
    }
    public static function update() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $project = Project::where('URL', $_POST['PROJECT_ID']);
            if(!$project || $project->OWNER_ID !== $_SESSION['ID']) {
                $response = [
                    'type' => 'error',
                    'message' => 'There was an error adding the task'
                ];
                echo json_encode($response);
                return;
            }
            $task = new Task($_POST);
            $task->PROJECT_ID = $project->ID;
            $result = $task->save();
            if($result) {
                $response = [
                    'type' => 'success',
                    'ID' => $task->ID,
                    'PROJECT_ID' => $project->ID,
                    'message' => 'Task updated correctly'
                ];
                echo json_encode(['response' => $response]);
            }
        }
    }
    public static function delete() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $project = Project::where('URL', $_POST['PROJECT_ID']);
            if(!$project || $project->OWNER_ID !== $_SESSION['ID']) {
                $response = [
                    'type' => 'error',
                    'message' => 'There was an error adding the task'
                ];
                echo json_encode($response);
                return;
            }
            $task = new Task($_POST);
            $result = $task->delete();
            $result = [
                'result' => $result,
                'message' => 'Deleted Correctly',
                'type' => 'success'
            ];
            echo json_encode($result);
        }
    }
}