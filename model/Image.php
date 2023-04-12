<?php
require_once('config/Connect_bddClass.php');
class Image{
    public $id;
    public $nom;
    public $image;
    public $idProduct; 
}


class ImageRepository extends Connect_bdd{

    public function __construct(){
        parent::__construct();
    }

    public function getImageByProductId($productId){
        $req =  $this->bdd->prepare('SELECT * FROM images WHERE id_produit = ?');
        $req->execute([$productId]);
        $dataImage = $req->fetch();
        $image = new Image();
        $image->id = $dataImage['id'];
        $image->nom = $dataImage['nom'];
        $image->image = $dataImage['image'];
        $image->idProduct = $dataImage['id_produit'];
        return $image;
    }
}
?>
