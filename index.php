<?php
require_once('controller/homeController.php');
if (isset($_GET['action']) && $_GET['action'] !== '' && !isset($_GET['admin'])) {
    switch($_GET['action']) {
        case 'LoginForm':
            loginForm();
            break;
        
        case 'LoginTraitement':
            login();
            break;
        default:
            homepage();
            break;
    }
}else{
    homepage();
}

?>