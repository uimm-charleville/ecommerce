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
            $_SESSION['id_role'] = $user->id_role;
        }else{
            header('Location: /?action=LoginForm');
        }
    }else{
        header('Location: ?action=LoginForm');
    }
} 

function signInForm(){
    if(key_exists('id_role',$_SESSION)){
        // header('Location: /?action=LoginForm');
        echo 'allez a ladmin';
    }else{
        require('view/form_signin.php');
    }
}

function signIn(){
    $userRepo = new UserRepository();
    $user = new User();
    if($user->createToSignin($_POST)){
        // le user est créé sans attributs vide
        $userTmpEmail = $userRepo->getUserByEmail($_POST['email']);
        $userTmpPseudo = $userRepo->getUserByEmail($_POST['pseudo']);
        if($userTmpEmail == []){
            if($userTmpPseudo == []) {
                $user->mdp = password_hash($user->mdp, PASSWORD_BCRYPT);
                $userRepo->inserUser($user);
                header('Location: ?action=LoginForm');
            }else{
                //pseudo deja existant
                header('Location: ?action=SignInForm');
            }   
        }else{
            //email deja existant
            header('Location: ?action=SignInForm');
        }
    }else{
        // champ vide 
        header('Location: ?action=SignInForm');
    }
    
}
?>