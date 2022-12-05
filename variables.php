<?php

session_start();

// App
$base_path = '/SpeedTech/';
$errors = [];
$success_message = null;

// Database
$database_server = 'localhost:3306';
$database_username = 'root';
$database_password = '';
$database_name = 'spdtechi_coredatabase';

// User
$current_user_id = null;
$is_admin = false;
$session_id = null;

if(isset($_SESSION['SESSION'])) {
    $session_id = $_SESSION['SESSION'];
}

if(isset($_SESSION['USER_ID'])) {
    $current_user_id = $_SESSION['USER_ID'];
}

if(isset($_SESSION['IS_ADMIN'])) {
    $is_admin = $_SESSION['IS_ADMIN'];
}

