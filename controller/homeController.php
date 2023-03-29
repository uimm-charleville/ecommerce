<?php
session_start();
require_once('model/Product.php');
require_once('model/User.php');

function homepage()
{   
	$productRepository = new ProductRepository();
	$products = $productRepository->getProducts();

	require('views/homePage.php');
}

function login(){
    require ('views/login.php');
}

function logger(){
    $userRepository = new UserRepository();
    $user = $userRepository->findByEmailAndPseudo($_POST['email'],$_POST['pseudo']);
    if($user != []){
        if(password_verify($_POST['mdp'],$user->mdp)){
            $_SESSION['ETAT']="conection reussie";
            $_SESSION['username'] = $user->pseudo;
            $_SESSION['id_role'] = $user->idRole;
            $_SESSION['panier'] = [];
            header('Location: /');
        }else{
            $_SESSION['ETAT']="mauvais mot de passe";
            header('Location: /?action=Login');
        }
    }else{
        $_SESSION['ETAT']="mauvais pseudo ou email";
        header('Location: /?action=Login');
    }
}

function logout(){
    session_destroy();
    header('Location: /');
}

function signinform(){
    require('views/signin.php');
}

function signin(){
    $userRepository = new UserRepository();
    $user = $userRepository->findByEmailAndPseudo($_POST['email'],$_POST['pseudo']);
    if($user == []){
        $user = new User();
        $tmp = $user->createToSignin($_POST);
        if($tmp){
            $userRepository->insertUser($user);
            header('Location: /?action=Login');
        }else{
            header('Location: /?action=SignInForm');
        }
    }else{
        header('Location: /?action=SignInForm');
    }
}

function show(){
    $idProduct = $_GET['idProduct'];
    
    require('views/show.php');
}