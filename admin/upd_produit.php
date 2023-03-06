<?php
    include '../config/connect_bdd.php';
    require '../config/functions.php';

    if(!empty($_FILES['image']))
    {
        $nameFile = $_FILES['image']['name'];
        $typeFile = $_FILES['image']['type'];
        $tmpFile = $_FILES['image']['tmp_name'];
        $errorFile = $_FILES['image']['error'];
        $sizeFile = $_FILES['image']['size'];

        $extensions = ['png', 'jpg', 'jpeg', 'gif'];
        $type = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif',];

        $extension = explode('.', $nameFile);

        $max_size =200000;

        if(in_array($typeFile, $type))
        {
            if(count($extension) <=2 && in_array(strtolower(end($extension)), $extensions))
            {
                if($sizeFile <= $max_size && $errorFile == 0)
                {
                    if(move_uploaded_file($tmpFile, $image = '../upload/' . uniqid() . '.' . end($extension)) )
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

    $nom_image = $_POST['nom'];
    $id =  $_GET['$id'];

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
                        update_product($nom, $desc, $prix, $id);
                        update_image($nom, $image, $id);
                        header('location: admin.php');

                    } catch (Exception $e) {
                        die('Erreur : '.$e->getMessage());
                    }              
            }
        }
    }

?>