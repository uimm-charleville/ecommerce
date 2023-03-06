<?php
include '../config/connect_bdd.php';
require '../config/functions.php';

$id = $_GET['id'];

try {
        delete_product($id);
        // header('location: admin.php');

    } catch (Exception $e) {
        die('Erreur : '.$e->getMessage());
    }

?>