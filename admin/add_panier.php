<?php
include '../config/connect_bdd.php';
require '../config/functions.php';
session_start();

if(isset($_POST['ajout_panier'])) 
{
    $result = view_product_basket($_POST['id_produit']);
    foreach ( $result as $produit)
    {
        $nom_produit = $produit->nom;
        $id_produit = $produit->id;
        $prix = $produit->prix;
      

        $add = add_product_in_basket($nom_produit, $id_produit, $prix);
        var_dump($add);
        die();
        // var_dump($_SESSION['panier']);

        header('Location: ../index.php');
    }
}


?>