<?php
include '../config/connect_bdd.php';
require '../config/functions.php';

$errors = array();

if(empty($_POST['nom']) || !preg_match('/^[a-zA-Z]+$/',$_POST['nom'])){
    $errors['nom']="Le nom est incorect";
}

if(empty($_POST['prenom']) || !preg_match('/^[a-zA-Z]+$/',$_POST['prenom'])){
    $errors['prenom']="Le prenom est incorect";
}

if(empty($_POST['email']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
    $errors['email']="L'email est incorect";
}else{
    // verif_mail();
    $vermail=$bdd->prepare("SELECT id FROM users WHERE email= ? ");
    $vermail->execute([$_POST['email']]);
    $mail=$vermail->fetch();
    if($mail){
        $errors['email']="L'adresse mail existe deja";
    }
}

if(empty($_POST['pseudo']) || !preg_match('/^[a-zA-Z0-9_]+$/',$_POST['pseudo'])){
    $errors['pseudo']="Le pseudo est incorect";
}else{
    // verif_pseudo();
    $ver=$bdd->prepare("SELECT id FROM users WHERE pseudo= ? ");
    $ver->execute([$_POST['pseudo']]);
    $pseudo=$ver->fetch();
    if($pseudo){
        $errors['pseudo']="Le pseudo existe deja";
    }

}
if(empty($_POST['mdp']) || $_POST['mdp']!=$_POST['confirm_mdp'] || !preg_match('/^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/',$_POST['mdp'])){
    $errors['mdp']="Le mot de passe est incorect,";
}

if(empty($errors)){
    // add_user();
    $req=$bdd->prepare("INSERT INTO users SET nom = ? , prenom = ? , email = ?, pseudo = ? , mdp = ? ,id_role = ?" );
    $password=password_hash($_POST['mdp'],PASSWORD_BCRYPT);
    $req->execute([$_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['pseudo'],$password,2]);
    echo "<p>inscription reussie</p>";
    header('location: form_login.php');
}else{

    debug($errors);
}
?>