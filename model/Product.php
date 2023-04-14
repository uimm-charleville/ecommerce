<?php
require_once('config/Connect_bddClass.php');
require_once('model/Image.php');
class Product{
    public $id;
    public $nom;
    public $description;
    public $prix;
    public $image;

    public function createToInsert(array $productForm):bool{
        if(!isset($productForm['nom']) OR $productForm['nom'] == ''){

            return false;
        }
        if(!isset($productForm['desc']) OR $productForm['desc'] == ''){

            return false;
        }
        if(!isset($productForm['prix']) or $productForm['prix'] == '') {

            return false;
        }

        $image = new Image();
        $image->setImage();
        $this->nom = $productForm['nom'];
        $this->description = $productForm['desc'];
        $this->prix = $productForm['prix'];
        $this->image = $image;

        return true;
    }

}


class ProductRepository extends Connect_bdd{

    public function __construct(){
        parent::__construct();
    }
    
    public function getProducts(){
        $req = $this->bdd->prepare('SELECT * FROM produits');
        $req->execute();
        $datas = $req->fetchAll();
        $products = [];
        foreach($datas as $productBdd){
            $imageRepo = new ImageRepository();
            $image = $imageRepo->getImageByProductId($productBdd['id']);
            $product = new Product();
            $product->id = $productBdd['id'];
            $product->nom = $productBdd['nom'];
            $product->description = $productBdd['description'];
            $product->prix = $productBdd['prix'];
            $product->image = $image;
            $products[] = $product;
        } 
        return $products;
    }

    public function insertProduct($produit){
        $req = $this->bdd->prepare("INSERT INTO produits (nom, description, prix)
        VALUES (?,?,?)");
        $req->execute([
            $produit->nom,
            $produit->description,
            $produit->prix
        ]);
        $produit->image->idProduct = $this->bdd->lastInsertId();   
        $imageRepo = new ImageRepository();
        $imageRepo->insertImage($produit->image);


    }
}
?>