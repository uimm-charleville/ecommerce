<?php
include '../config/connect_bdd.php';
require '../config/functions.php';

$id = $_GET['id'];
var_dump($_GET);
die();

try {
        del_product_in_basket($id);

    } catch (Exception $e) {
        die('Erreur : '.$e->getMessage());
    }

?>