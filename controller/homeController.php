<?php
require_once('model/Product.php');
function homepage(){
    $produit = new ProductRepository();
    $Produits = $produit->getProducts();

    include('view/homePage.php');
}

function loginForm(){
    include('view/form_login.php');
}

function login(){
    var_dump('test');
}   
?>