<?php

$DB = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);

if(!$DB) {
    echo "Error: It could not to connect to MySQL.";
    echo "errno of depuration: " . mysqli_connect_errno();
    echo "errno of depuration: " . mysqli_connect_errno();
    exit;
}