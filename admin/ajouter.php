<?php
session_start();
if($_SESSION['id_role'] != 1)
{
    header('location: form_login.php');
}
header('Content-type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    
</head>
<body>
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row row-cols-1 row cols-sm-2 row-cols-md-3 g-3">
                <form action="add_produit.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Nom du produit</label>
                        <input type="text" class="form-control" name="nom" placeholder="Entrer un nom de produit" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Ajout de l'image</label>
                        <!--<input type="text" class="form-control" name="image" placeholder="Nom de l'image" required>-->
                        <input type="file" class="form-control" name="image">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Description du produit</label>
                        <textarea class="form-control" name="desc" placeholder="Entrer un nom de produit" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Prix du produit</label>
                        <input type="number" class="form-control" name="prix" placeholder="Entrer un prix de produit" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="valider">Ajouter un nouveau produit</button>
                </form>
            </div>
        </div>
    </div>
    <div>
        <center><button type="submit" onclick="document.location.href = 'admin.php';" class="btn btn-primary" name="valider">Retour</button><center>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>