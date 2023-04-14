<?php
require_once('config/Connect_bddClass.php');
class Image{
    public $id;
    public $nom;
    public $image;
    public $idProduct; 

    public function setImage(){
        if(!empty($_FILES['image']))
        {
        $path = 'upload/';
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
                    if(move_uploaded_file($tmpFile, $image = 'upload/' . uniqid() . '.' . end($extension)) )
                    {
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

    $this->nom = $_POST['nom'];
    $this->image = $image;

    }
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

    public function insertImage($image){
        $req = $this->bdd->prepare("INSERT INTO images (nom, image, id_produit)
        VALUES (?,?,?)");
        $req->execute([
            $image->nom,
            $image->image,
            $image->idProduct,
        ]);
    }
}
?>
