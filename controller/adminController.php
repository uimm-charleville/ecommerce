<?php
function admin(){
    $productRepo = new ProductRepository();
    $Produits = $productRepo->getProducts();
    
    require('view/admin.php');
} 
function addProductForm(){
    if($_SESSION['id_role'] != 1)
    {
        header('location: form_login.php');
    }else{
        require('view/ajouter.php'); 

    }
}
function addProduct(){
    $productRepo = new ProductRepository();
    $product = new Product();
    if($product->createToInsert($_POST)){
        $productRepo->insertProduct($product);
    }
}

?>