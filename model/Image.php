<?php
class Image{
    public int $id;
    public string $nom;
    public string $image;
    public int $idProduit;
}

class ImageRepository{
    public ?PDO $db = null;
    
    function getImageByIdProduct(int $idProduit){
        $this->dbConnect($this);
        $statement = $this->db->prepare(
            "SELECT * FROM images WHERE id_produit = ?");
        $statement->execute([$idProduit]);
        $resReq = $statement->fetch();
        $image = new Image();
        $image->id = $resReq['id'];
        $image->nom = $resReq['nom'];
        $image->image = $resReq['image'];
        $image->idProduit = $resReq['id_produit'];

        return $image;


    }
    function dbConnect(ImageRepository $imageRepository){
        $user = "admin";
        $pass = "root";
        $host = "database";
        $port = '3306';
        $db = "projet_poo";
        if ($imageRepository->db === null) {
            $imageRepository->db =  new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
    }
}