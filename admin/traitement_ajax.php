<?php
include '../config/connect_bdd.php';
require '../config/functions.php';

$id = $_POST['id'];

if(isset($_POST['action']) && $_POST['action'] == "confirm_del")
{
    try {
         $req = $bdd->prepare("DELETE FROM produits WHERE id=?");
         $req->execute([$id]);
         $req->closeCursor();
         $req2 = $bdd->prepare("DELETE FROM images WHERE id_produit=?");
         $req2->execute([$id]);
        //header('location: admin.php');

    } catch (Exception $e) {
        die('Erreur : '.$e->getMessage());
    }

}
?>