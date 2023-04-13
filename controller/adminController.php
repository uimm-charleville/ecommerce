<?php
function admin(){
    $productRepo = new ProductRepository();
    $Produits = $productRepo->getProducts();
    
    require('view/admin.php');
} 


?>