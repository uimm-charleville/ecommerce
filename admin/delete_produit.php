<?php
session_start();
if($_SESSION['id_role'] != 1)
{
header('location: form_login.php');
}

require '../config/functions.php';
$Produits = view_product();
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
                <form action="del_produit.php" method="post">

                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Identifiant</label>
                        <input type="number" class="form-control" name="idproduit" placeholder="Selectionné un produit" required>
                    </div>

                    <button type="submit" class="btn btn-primary form-label"  name="valider">Supprimer un produit</button>
                </form>
            </div>
            <div class="row row-cols-1 row cols-sm-2 row-cols-md-3 g-3">
                <?php foreach ($Produits as $produit): ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <img src="<?php echo $produit->image ?>" height="50" width="50">
                        <h4><?= $produit->id ?></h4>
                        <div class="btn-group">
                            <!--<button type="button" class="btn btn-sm btn-outline-secondary">View</button> -->
                            <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Buy</button> -->
                        </div>

                            <!-- <button type="button" class="w-100 btn btn-lg btn-outline-primary">Sign up for free</button> -->
                        
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>