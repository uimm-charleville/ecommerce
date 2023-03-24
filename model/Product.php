<?php 
require_once('Image.php');
class Product{
    public int $id;
    public string $name;
    public string $description;
    public int $prix;
    public Image $image;

    public function createToInsert(array $productForm){
        if(!isset($productForm['nom']) && $productForm['nom'] == ''){

            return false;
        }
        if(!isset($productForm['desc']) && $productForm['desc'] == ''){

            return false;
        }
        if(!isset($productForm['prix']) && $productForm['prix'] == 0){
            
            return false;
        }
        $image = new Image();

        $this->name = $productForm['nom'];
        $this->description = $productForm['desc'];
        $this->prix = $productForm['prix'];
        $this->image = $image->setImage();
        $this->image->nom = $this->name;

        
        return true;
    }
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
        $product = new Product();
        $product->id = $row['id'];
        $product->name = $row['nom'];
        $product->description = $row['description'];
        $product->prix = $row['prix'];

        return $product;
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
        	$product->name = $ProductEach['nom'];
        	$product->description = $ProductEach['description'];
        	$product->prix = $ProductEach['prix'];
            $product->image =  $imageRepo->getImageByIdProduct($product->id);
        	$products[] = $product;

    	}

    	return $products;
	}
    
    public function insertProduct(Product $product){
        $this->dbConnect($this);
        $req = $this->db->prepare("INSERT INTO produits (nom, description, prix)
        VALUES (?,?,?)");
        $req->execute([
            $product->name,
            $product->description,
            $product->prix,
        ]);
        $product->id = $this->db->lastInsertId();
        $product->image->idProduct = $product->id;
        $imageRepo = new ImageRepository();
        $imageRepo->insertImage($product->image);
    }

    public function deleteProductById($idProduct){
        $this->dbConnect($this);
        $req = $this->db->prepare('DELETE FROM produits WHERE id = ?');
        $req->execute([$idProduct]);
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