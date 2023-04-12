<?php
require_once('model/Product.php');
require_once('model/User.php');
function homepage(){
    $produit = new ProductRepository();
    $Produits = $produit->getProducts();

    require('view/homePage.php');
}

function loginForm(){
    if(key_exists('id_role',$_SESSION)){
        // header('Location: /?action=LoginForm');
        echo 'allez a ladmin';
    }else{
        require('view/form_login.php');
    }
}

function login(){
    $userRepo = new UserRepository();
    $user = $userRepo->getUserByEmailAndPseudo($_POST['email'],$_POST['pseudo']);
    if($user != []){
        if(password_verify($_POST['mdp'],$user->mdp)){
            $_SESSION['id_role'] = $user;
        }else{
            header('Location: /?action=LoginForm');
        }
    }else{
        header('Location: ?action=LoginForm');
    }
}   
?>