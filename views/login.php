<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Ecommmerce Simplon Shop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <style>
    html,
    body {
    height: 100%;
    }

    body {
    display: -ms-flexbox;
    display: -webkit-box;
    display: flex;
    -ms-flex-align: center;
    -ms-flex-pack: center;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #f5f5f5;
    }

    .form-signin {
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;
    }
    .form-signin .checkbox {
    font-weight: 400;
    }
    .form-signin .form-control {
    position: relative;
    box-sizing: border-box;
    height: auto;
    padding: 10px;
    font-size: 16px;
    }
    .form-signin .form-control:focus {
    z-index: 2;
    }
    .form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    }
    </style>
  </head>
  <body class="text-center">
    <form action="<?= urldecode('?action=Logger')?>" class="form-signin" method="POST">
      <h1 class="h3 mb-3 font-weight-normal">Connexion</h1>
        <?php
            if(isset($_SESSION['ETAT']) && $_SESSION['ETAT'] !== ''){
                    echo "<p>".$_SESSION['ETAT']."</p>";
                    unset($_SESSION['ETAT']);
            }
        ?>
      <label for="inputEmail" class="sr-only ">Adresse mail</label>
      <input type="email" id="inputEmail" class="form-control" placeholder="Entrer votre email" name="email" required autofocus>
      <label for="inputNickName" class="sr-only ">Pseudo</label>
      <input type="name" id="inputNickName" class="form-control" placeholder="Entrer votre pseudo" name="pseudo" required>
      <label for="inputPassword" class="sr-only">Mot de passe</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Entrer votre mot de passe" name="mdp" required>
      <div class="checkbox mb-3">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
      </div>
       <div>
          <center><a href="/" class="btn btn-primary" name="valider">Retour</a><center>
      </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  </body>
</html>