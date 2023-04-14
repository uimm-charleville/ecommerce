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

    public function getProduct($idProduit){
        $req = $this->bdd->prepare('SELECT * FROM produits WHERE id = ?');
        $req->execute([$idProduit]);
        $dataProd = $req->fetch();
        $produit = new Product();
        $imageRepo = new ImageRepository();
        $produit->id = $dataProd['id'];
        $produit->description = $dataProd['description'];
        $produit->nom = $dataProd['nom'];
        $produit->prix = $dataProd['prix'];
        $produit->image = $imageRepo->getImageByProductId($idProduit);

        return $produit;
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

    function updateNom(int $idProduct,string $name): void{
        $req = $this->bdd->prepare('UPDATE produits SET nom = ? WHERE id = ?');
        $req->execute([$name,$idProduct]);
    }

    function updateDesc(int $idProduct,string $desc): void{
        $req = $this->bdd->prepare('UPDATE produits SET description = ? WHERE id = ?');
        $req->execute([$desc,$idProduct]);
    }

    function updatePrice(int $idProduct, $prix): void{
        $req = $this->bdd->prepare('UPDATE produits SET prix = ? WHERE id = ?');
        $req->execute([$prix,$idProduct]);
    }
}
?>