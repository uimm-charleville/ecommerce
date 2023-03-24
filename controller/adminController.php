<?php
require_once('model/Product.php');

function admin(){
    $productRepository = new ProductRepository();
	$products = $productRepository->getProducts();

    if(!empty($_SESSION) && $_SESSION['id_role'] == 1){
        require_once('views/admin.php');
    }else{
        header('Location: ?action=Login');
    }
    
}

function addProductForm(){
    if(!empty($_SESSION) && $_SESSION['id_role'] == 1){
        require_once('views/addProduct.php');
    }else{
        header('Location: ?action=Login');
    }
}

function addProduct(){
    $product = new Product();
    if($product->createToInsert($_POST)){
        $productRepository = new ProductRepository();
        $productRepository->insertProduct($product);
        header('Location: ?admin=');
    }else{
        header('Location: ?admin=&action=AddProduct');
    }

}