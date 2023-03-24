<?php
class Image{
    public int $id;
    public string $nom;
    public string $image;
    public int $idProduit;

    public function setImage(){
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
                            return $this;
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
    
        $nom_image = $_POST['nom'];
    
        if(isset($_POST['valider']))
        {
            if(isset($_POST['nom']) && isset($image) && isset($_POST['desc']) && isset($_POST['prix']))
            {
                if(!empty($_POST['nom']) && !empty($image) && !empty($_POST['desc']) && !empty($_POST['prix']))
                {
                    $nom = htmlspecialchars(strip_tags($_POST['nom']));
                    $desc = htmlspecialchars(strip_tags($_POST['desc']));
                    $prix = htmlspecialchars(strip_tags($_POST['prix']));
    
                    try {
                            add_product($nom, $desc, $prix);
    
                        } catch (Exception $e) {
                            die('Erreur : '.$e->getMessage());
                        }              
    
                    try {
                            $tab_id = last_id();
                            
                            $id = $tab_id[0][0];
                            add_image($nom_image, $image, $id);
                            header('location: admin.php');
    
                        } catch (Exception $e) {
                            die('Erreur : '.$e->getMessage());
                        }
                }
            }
        }
    
    }
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

    function insertImage(Image $image){
        $this->dbConnect($this);
        $req = $this->db->prepare('INSERT INTO images (nom, image, id_produit)
        VALUE (?,?,?)');
        $req->execute([
            $image->nom,
            $image->image,
            $image->idProduct,
        ]);
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