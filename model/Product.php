<?php 
require_once('Image.php');
/** 
* cette classe permet de mettre en place les produits 
*/
class Product{
    public int $id;
    public string $name;
    public string $description;
    public int $prix;
    public Image $image;

    /**
    * Cette fonction prend en parametre un tableau venant d'un formulaire ($_post)
    * @param array $productForm le tableau venant d'un formulaire
    * @return bool si c'est pas bon retourne false sinon true
    */
    public function createToInsert(array $productForm):bool{
        if (empty($productForm)){
            return false;
        }
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
        $image->setImage();
        $this->name = $productForm['nom'];
        $this->description = $productForm['desc'];
        $this->prix = $productForm['prix'];
        $this->image = $image;
        $this->image->nom = $this->name;

        
        return true;
    }
}
/**
* cette classe permet de gerer les produits en base de donnée 
*/
class ProductRepository{
    public ?PDO $db = null;

    /**
    * Cette fonction va retourner un produit de la base de donnée trouvé par son id
    * @param int $id un id de produit
    * @return Product le produit venant de la base de donée
    * 
    */
    public function getProduct(int $id): Product
    {
        $this->dbConnect($this);
        $statement = $this->db->prepare(
            "SELECT * FROM produits WHERE id = ?");
        $statement->execute([$id]);

        $row = $statement->fetch();
        $imageRepo = new ImageRepository();
        $product = new Product();
        $product->id = $row['id'];
        $product->name = $row['nom'];
        $product->description = $row['description'];
        $product->prix = $row['prix'];
        $product->image = $imageRepo->getImageByIdProduct($id);

        return $product;
    }

    /**
    * Cette fonction va retourner une collection produit de la base de donnée
    * @return array notre collection de produits 
    */
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

    /**
    * Cette fonction insert le produit en paramètre dans la base de donnée 
    * @param Product $product le produit a insérer dans la base de donnée
    */
    public function insertProduct(Product $product):void{
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

    /**
    * Cette fonction delete un produit de la base de donnée identifié par son id 
    * @param int $idProduct l'id du produit a supprimer de la base de donnée
    */
    public function deleteProductById(int $idProduct):void{
        $this->dbConnect($this);
        $req = $this->db->prepare('DELETE FROM produits WHERE id = ?');
        $req->execute([$idProduct]);
    }

    /**
    * Cette fonction modifie le nom d'un produit de la base de donnée identifié par son id 
    * @param int $idProduct l'id du produit a modifier de la base de donnée
    * @param string $name le nouveau nom du produit
    */
    function updateName(int $idProduct,string $name): void{
        $this->dbConnect($this);
        $req = $this->db->prepare('UPDATE produits SET nom = ? WHERE id = ?');
        $req->execute([$name,$idProduct]);
    }
    /**
    * Cette fonction modifie le prix d'un produit de la base de donnée identifié par son id 
    * @param int $idProduct l'id du produit a modifier de la base de donnée
    * @param float $price le nouveau prix du produit
    */
    function updatePrice(int $idProduct, int $price):void{
        $this->dbConnect($this);
        $req = $this->db->prepare('UPDATE produits SET prix = ? WHERE id = ?');
        $req->execute([$price,$idProduct]);
    }

    /**
    * Cette fonction modifie la description d'un produit de la base de donnée identifié par son id 
    * @param int $idProduct l'id du produit a modifier de la base de donnée
    * @param string $desc la nouvelle description du produit
    */
    function updateDesc(int $idProduct, string $desc):void{
        $this->dbConnect($this);
        $req = $this->db->prepare('UPDATE produits SET description = ? WHERE id = ?');
        $req->execute([$desc,$idProduct]);
    }
    
    /**
    * Cette fonction permet de se connecter a la base de donnée
    * @param ProductRepository $ProductRepository notre repository
    */
    function dbConnect(ProductRepository $ProductRepository):void{
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