<?php
if (isset($_GET['action']) && $_GET['action'] !== '') {
    switch($_GET['action']) {
        case 'addProduct':
            addProduct();
            break;
        case 'addProductForm':
            addProductForm();
            break;
        case 'updateProductForm':
            updateProductForm();
            break;
        case 'updateProduct':
            updateProduct();
            break;
        default:
            admin();
            break;
    }
}else{
    admin();
}

?>