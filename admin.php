<?php
if (isset($_GET['action']) && $_GET['action'] !== '') {
    switch($_GET['action']) {
        case 'admin':
            admin();
            break;
        default:
            admin();
            break;
    }
}

?>