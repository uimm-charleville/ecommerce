<?php
require_once('model/Product.php');
function homepage(){
    $produit = new ProductRepository();
    $Produits = $produit->getProducts();

    include('view/homePage.php');
}
?>