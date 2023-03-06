<?php

function add_product($nom, $desc, $prix)
{
    if(require("connect_bdd.php"))
    {
        $req = $bdd->prepare("INSERT INTO produits SET nom = ?, description = ? , prix = ?");
        $req->execute([$nom, $desc, $prix]);
        $req->closeCursor();
    }
}

function last_id()
{
    if(require("connect_bdd.php"))
    {
        $req = $bdd->prepare("SELECT MAX(id) FROM produits");
        $req->execute();
        $data = $req->fetchAll();
        return $data;
        var_dump($data);
        $req->closeCursor();

    }
}

function add_image($nom, $image, $id)
{
    if(require("connect_bdd.php"))
    {
        $req = $bdd->prepare("INSERT INTO images SET nom = ?, image = ? , id_produit = ?");
        $req->execute([$nom, $image, $id]);
        $req->closeCursor();
    }
}

function view_product()
{
    if(require("connect_bdd.php"))
    {
        $req = $bdd->prepare("SELECT * FROM produits INNER JOIN images ON produits.id = images.id_produit");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
    }
}

function delete_product($id)
{
     if(require("connect_bdd.php"))
     {
         $req = $bdd->prepare("DELETE FROM produits WHERE id=?");
         $req->execute([$id]);
         $req->closeCursor();
         $req2 = $bdd->prepare("DELETE FROM images WHERE id_produit=?");
         $req2->execute([$id]);
        $req2->closeCursor();
     }
}

function get_image()
{
   if(require("connect_bdd.php"))
    {
        $req=$bdd->prepare("SELECT * FROM images");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
    }
}

function update_product($nom, $desc, $prix, $id)
{
    if(require("connect_bdd.php"))
    {
        $req = $bdd->prepare("UPDATE produits SET nom = ?, description = ? , prix = ? WHERE id=$id");
        $req->execute([$nom, $desc, $prix]);
        $req->closeCursor();
    }
}
function update_image($nom, $image, $id)
{
    if(require("connect_bdd.php"))
    {
        $req =  $bdd->prepare("UPDATE images SET nom = ?, image = ? WHERE id_produit=$id");
        $req->execute([$nom, $image]);
        $req->closeCursor();
    }
}

function verif_mail()
{
    if(require("connect_bdd.php"))
    {
        $vermail=$bdd->prepare("SELECT id FROM users WHERE email= ? ");
        $vermail->execute([$_POST['email']]);
        $mail=$vermail->fetch();
        if($mail){
            $errors['email']="L'adresse mail existe deja";
        }
        $vermail->closeCursor();
    }
}

function verif_pseudo()
{
    if(require("connect_bdd.php"))
    {
        $ver=$bdd->prepare("SELECT id FROM users WHERE pseudo= ? ");
        $ver->execute([$_POST['pseudo']]);
        $pseudo=$ver->fetch();
        if($pseudo){
            $errors['pseudo']="Le pseudo existe deja";
        }
        $verpseudo->closeCursor();
    }
}

function add_user()
{
    if(require("connect_bdd.php"))
    {
        $req=$bdd->prepare("INSERT INTO users SET nom = ? , prenom = ? , email = ?, pseudo = ? , mdp = ? ,id_role = ?" );
        $password=password_hash($_POST['mdp'],PASSWORD_BCRYPT);
        $req->execute([$_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['pseudo'],$password,2]);
        $req->closeCursor();
    }
}

function create_basket()
{
    if(!isset($_SESSION['panier']))
    {
        
        $_SESSION['panier'] = [];
        $_SESSION['panier']['nom_produit'] = [];
        $_SESSION['panier']['id_produit'] = [];
        $_SESSION['panier']['prix'] = [];
    }
}

function view_product_basket($id)
{
    if(require("connect_bdd.php"))
    {
        $req = $bdd->prepare("SELECT * FROM produits WHERE id =$id");
        $req->execute();
        $produits=$req->fetchAll(PDO::FETCH_OBJ);
        return $produits;
        $req->closeCursor();
    }
}

function add_product_in_basket($nom_produit, $id_produit, $prix)
{
    create_basket();
    $p = [
        'nom_produit' => $nom_produit,
        'id_produit' => $id_produit,
        'prix' => $prix,
    ];
    array_push($_SESSION['panier'], $p);

}

function del_product_in_basket($id_del_produit)
{
    $position_produit = array_search($id_del_produit,  $_SESSION['panier']['id_produit']);
    if ($position_produit !== false)
    {
        array_splice($_SESSION['panier']['nom_produit'], $position_produit, 1);
        array_splice($_SESSION['panier']['id_produit'], $position_produit, 1);
        array_splice($_SESSION['panier']['prix'], $position_produit, 1);
    }
}

function drop_basket()
{
  unset($_SESSION['panier']);
}

function Totalprice()
{
   $total=0;
   for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
   {
      $total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];
   }
   return round($total,2); 
}

function debug($variable)
{
    echo '<pre>'.print_r($variable,true).'<pre>';
}
?>