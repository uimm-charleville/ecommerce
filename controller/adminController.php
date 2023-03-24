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