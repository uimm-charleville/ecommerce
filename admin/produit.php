<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require '../config/functions.php';

$id = $_GET['id_produit'];


if(isset($_GET['id_produit']))
{
    $produits = view_product_basket($id);

    foreach ($produits as $produit)
    {
        $contenu = "";
        $contenu .= "<h2>Nom : $produit->nom</h2><hr><br>";
        $contenu .= "<p>Prix : $produit->prix €</p><br>";
        $contenu .= "<form method='post' action='add_panier.php'>";
        $contenu .= "<input type='hidden' name='id_produit' value='$produit->id'>";
        $contenu .= "<input type='submit' name='ajout_panier' value='ajout au panier'>";
        $contenu .= "</form>";
    }
    echo $contenu;
}

?>