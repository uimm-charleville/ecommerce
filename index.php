<?php
session_start();
require_once('controller/homeController.php');
require_once('controller/adminController.php');
if (isset($_GET['action']) && $_GET['action'] !== '' && !isset($_GET['admin'])) {
    switch($_GET['action']) {
        case 'LoginForm':
            loginForm();
            break;
        case 'LoginTraitement':
            login();
            break;
        case 'SignInForm':
            signInForm();
            break;
        case 'SignInTraitement':
            signIn();
            break;
        default:
            homepage();
            break;
    }
}else{
    
    if(isset($_GET['admin']) && (!empty($_SESSION) && $_SESSION['id_role'] == 1)){
        require('admin.php');
    }else{
        homepage();
    }
}

?>