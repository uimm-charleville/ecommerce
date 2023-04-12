
<?php
require_once('config/Connect_bddClass.php');
require_once('model/Image.php');
class Product{
    public $id;
    public $nom;
    public $description;
    public $prix;
    public $image;

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
}
?>