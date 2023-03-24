<?php
require_once('controller/homeController.php');

if (isset($_GET['action']) && $_GET['action'] !== '' && !isset($_GET['admin'])) {
  switch($_GET['action']){
    case 'Login':
      login();
      break;
    case 'Logger';
      logger();
      break;
    case 'Logout';
      logout();
      break;
    case 'SignInForm':
      signinform();
      break;
    case 'SignIn':
      signin();
      break;
    default:
      homepage();
      break;
  }
}else{
  if(isset($_GET['admin']) && (!empty($_SESSION) && $_SESSION['id_role'] == 1)){
    require_once('admin.php');
  }else{
    homepage();
  }
}
