<?php 
require_once('Image.php');
class Product{
    public int $id;
    public string $nom;
    public string $description;
    public int $prix;
    public Image $image;
}

class ProductRepository{
    public ?PDO $db = null;

    public function getProduct(int $id): Post
    {
        $this->dbConnect($this);
        $statement = $this->db->prepare(
            "SELECT * FROM produits WHERE id = ?");
        $statement->execute([$id]);

        $row = $statement->fetch();
        $Product = new Product();
        $Product->id = $row['id'];
        $Product->nom = $row['nom'];
        $Product->description = $row['description'];
        $Product->prix = $row['prix'];

        return $Product;
    }

    public function getProducts(): array
	{
    	$this->dbConnect($this);
    	$statement = $this->db->prepare(
        	"SELECT * FROM produits");
        $statement->execute();
        $resReq = $statement->fetchAll();
    	$products = [];
    	foreach($resReq as $ProductEach) {
        	$product = new Product();
            $imageRepo = new ImageRepository();

        	$product->id = $ProductEach['id'];
        	$product->nom = $ProductEach['nom'];
        	$product->description = $ProductEach['description'];
        	$product->prix = $ProductEach['prix'];
            $product->image =  $imageRepo->getImageByIdProduct($product->id);
        	$products[] = $product;
    	}

    	return $products;
	} 
    
    function dbConnect(ProductRepository $ProductRepository){
        $user = "admin";
        $pass = "root";
        $host = "database";
        $port = '3306';
        $db = "projet_poo";
        if ($ProductRepository->db === null) {
            $ProductRepository->db =  new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
    }
}