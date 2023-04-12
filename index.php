<?php
require_once('controller/homeController.php');
if (isset($_GET['action']) && $_GET['action'] !== '' && !isset($_GET['admin'])) {
    switch($_GET['action']) {
        case 'Login':
            login();
            break;
        default:
            homepage();
            break;
    }
}
?>