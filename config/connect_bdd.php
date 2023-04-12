<?php
try {
    $user = "admin";
    $pass = "root";
    $host = "database";
    $port = '3306';
    $db = "projet_poo";
    
    $bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    return $bdd;
} catch (Exception $e) {
    die('Erreur : '.$e->getMessage());
}

?>