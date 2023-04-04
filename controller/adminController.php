<?php
require_once('model/Product.php');

function admin(): void{
    $productRepository = new ProductRepository();
	$products = $productRepository->getProducts();

    if(!empty($_SESSION) && $_SESSION['id_role'] == 1){
        require_once('views/admin.php');
    }else{
        header('Location: ?action=Login');
    }
    
}

function addProductForm():void{
    if(!empty($_SESSION) && $_SESSION['id_role'] == 1){
        require_once('views/addProduct.php');
    }else{
        header('Location: ?action=Login');
    }
}

function addProduct():void{
    $product = new Product();
    if($product->createToInsert($_POST)){
        $productRepository = new ProductRepository();
        $productRepository->insertProduct($product);
        header('Location: ?admin=');
    }else{
        header('Location: ?admin=&action=AddProduct');
    }

}

function delProduct():void{
    var_dump($_POST['id']);
    $productRepository = new ProductRepository; 
    $imageRepository = new ImageRepository();
    $imageRepository->deleteImageByIdProduct($_POST['id']);
    $productRepository->deleteProductById($_POST['id']);
}

function editProductForm():void{
    $productRepo = new ProductRepository();
    $product = $productRepo->getProduct($_GET['idProduct']);
    require_once('views/editProduct.php');
}

function editProduct():void{
    $idProduct = $_GET['idProduct'];
    $imageRepository = new ImageRepository;
    $productRepository = new ProductRepository;
    // var_dump($_POST);
    // die;
    if(isset($_POST['nom'])){
        if ($_POST['nom'] !="") {
            $productRepository->updateName($idProduct, $_POST['nom']);
        }
    }
    if(isset($_FILES['image'])){
        if ($_FILES['image']['full_path'] !="") {
            $imageRepository->deleteImageByIdProduct($idProduct);
            $image = new Image();
            $image->setImage();
            $imageRepository->insertImage($image);
        }
    }
    if(isset($_POST['desc'])){
        if ($_POST['desc'] !="") {
            $productRepository->updateDesc($idProduct, $_POST['desc']);
        }
    }
    if(isset($_POST['prix'])){
        if ($_POST['prix'] != "") {
            $productRepository->updatePrice($idProduct, $_POST['prix']);
        }
    }

    header('Location: ?admin=');
}