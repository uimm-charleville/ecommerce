<?php
/** 
* cette classe permet de mettre en place les Images 
*/
class Image{
    public int $id;
    public string $nom;
    public string $image;
    public int $idProduct;

    /** 
    * cette function permet de créer l'objet image a inserer par la suite 
    */
    public function setImage(): void{
        $path = 'upload/';
        if(!empty($_FILES['image']))
        {
            $nameFile = $_FILES['image']['name'];
            $typeFile = $_FILES['image']['type'];
            $tmpFile = $_FILES['image']['tmp_name'];
            $errorFile = $_FILES['image']['error'];
            $sizeFile = $_FILES['image']['size'];
    
            $extensions = ['png', 'jpg', 'jpeg', 'gif', 'jiff'];
            $type = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/jiff'];
    
            $extension = explode('.', $nameFile);
    
            $max_size =500000;
    
            if(in_array($typeFile, $type))
            {
                if(count($extension) <=2 && in_array(strtolower(end($extension)), $extensions))
                {
                    if($sizeFile <= $max_size && $errorFile == 0)
                    {
                        if(move_uploaded_file($tmpFile, $image = $path . uniqid() . '.' . end($extension)) )
                        {
                            $this->nom = '';
                            $this->image=$image;
                            echo "upload  effectué !";
                        }
                        else
                        {
                            echo "Echec de l'upload de l'image !";
                        }
                    }
                    else
                    {
                        echo "Erreur le poids de l'image est trop élevé !";
                    }
                }
                else
                {
                    echo "Merci d'upload une image !";
                }
            }
            else
            {
                echo "Type non autorisé !";
            }
        }
    }
}

/**
* cette classe permet de gerer les Images en base de donnée 
*/
class ImageRepository{
    public ?PDO $db = null;
    
    /**
    * Cette fonction va retourner une image de la base de donnée trouvé par un id de produit
    * @param int $idProduct un id de produit
    * @return Image l'objet image constuit via les données de la base de donnée
    */
    function getImageByIdProduct(int $idProduct): Image{
        $this->dbConnect($this);
        $statement = $this->db->prepare(
            "SELECT * FROM images WHERE id_produit = ?");
        $statement->execute([$idProduct]);
        $resReq = $statement->fetch();
        $image = new Image();
        $image->id = $resReq['id'];
        $image->nom = $resReq['nom'];
        $image->image = $resReq['image'];
        $image->idProduct = $resReq['id_produit'];

        return $image;
    }


    /**
    * Cette fonction insert l'image en paramètre dans la base de donnée 
    * @param Image $image l'image a insérer dans la base de donnée
    */
    function insertImage(Image $image): void{
        $this->dbConnect($this);
        $req = $this->db->prepare('INSERT INTO images (nom, image, id_produit)
        VALUE (?,?,?)');
        $req->execute([
            $image->nom,
            $image->image,
            $image->idProduct,
        ]);
    }
    
    /**
    * Cette fonction delete une Image lié a un produit de la base de donnée identifié par un id de produit
    * @param int $idProduct l'id du produit du quel l'image sera supprimé 
    */

    public function deleteImageByIdProduct(int $idProduct):void{
        $this->dbConnect($this);
        $req = $this->db->prepare('DELETE FROM images WHERE id_produit = ?');
        $req->execute([$idProduct]);
    }

    /**
    * Cette fonction permet de se connecter a la base de donnée
    * @param ImageRepository $imageRepository notre repository
    */
    function dbConnect(ImageRepository $imageRepository): void{
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