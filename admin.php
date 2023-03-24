<?php
require_once('controller/adminController.php');
if(isset($_GET['action']) && $_GET['action'] !== '') {
    if($_GET['action'] == 'add'){

    }else{
        switch($_GET['action']){
            case 'AddProductForm':
                addProductForm();
                break;
            case 'AddProduct':
                addProduct();
                break;
            default:
                admin();
                break;
          }
    }
}else{
    admin();
}