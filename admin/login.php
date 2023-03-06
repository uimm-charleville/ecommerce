<?php
session_start();
// var_dump($_POST);
// die();
include '../config/connect_bdd.php';
require '../config/functions.php';
$mail=$_POST['email'];
$mdp=$_POST['mdp'];
$pseudo=$_POST['pseudo'];

$reqpseudo=$bdd->prepare("SELECT pseudo,id,id_role FROM users");
$reqpseudo->execute();
$bool="false";
while($data=$reqpseudo->fetch(PDO::FETCH_OBJ)){
    if($pseudo==$data->pseudo){
        $bool="true";
        $id=$data->id;
        $id_role=$data->id_role;
    }
}
var_dump($data);
if($bool){
    $reqmdp=$bdd->prepare("SELECT mdp FROM users WHERE  id=$id");
    $reqmdp->execute();
    $mdpuser=$reqmdp->fetch(PDO::FETCH_OBJ);
    $mdpuser=$mdpuser->mdp;
    $mdpval=password_verify($mdp,$mdpuser);

    if($mdpval){
        $_SESSION['ETAT']="conection reussie";
        $_SESSION['username'] = $pseudo;
        $_SESSION['id_role'] = $id_role;
        $_SESSION['panier'] = [];
        header('Location: ../index.php');
    }else{
        $_SESSION['ETAT']="Mot de passe invalide";
        header('Location: ../index.php');
    }
}
?>