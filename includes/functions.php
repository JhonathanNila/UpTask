<?php

function debug($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}
function isAuth() : void {
    if(!isset($_SESSION['LOGGED_IN'])) {
        header('Location: /');
    }
}