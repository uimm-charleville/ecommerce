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

function updateProductForm(){
    if($_SESSION['id_role'] != 1)
    {
        header('location: form_login.php');
    }else{
        $productRepo = new ProductRepository();
        $produit = $productRepo->getProduct($_GET['idProduct']); 
        require('view/update_produit.php'); 
    }
}

function updateProduct(){
    $idProduit = $_GET['idProduit'];
    $productRepo = new ProductRepository();
    $imageRepo = new ImageRepository();

    if(isset($_POST['nom'])){
        if ($_POST['nom'] !="") {
            $productRepo->updateNom($idProduit, $_POST['nom']);
        }
    }
    if(isset($_FILES['image'])) {
        if ($_FILES['image']['full_path'] !="") {
            $imageRepo->deleteImageByIdProduct($idProduit);
            $image = new Image();
            $image->setImage();
            $image->idProduct = $idProduit; 
            $imageRepo->insertImage($image);
        }
    }
    if(isset($_POST['desc'])){
        

        if ($_POST['desc'] !="") {
            $productRepo->updateDesc($idProduit, $_POST['desc']);
        }
    }
    var_dump($_POST);
    if(isset($_POST['prix'])){
        if ($_POST['prix'] != "") {
            $productRepo->updatePrice($idProduit, $_POST['prix']);
        }
    }

}

?>