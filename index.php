<?php
require_once('controller/homeController.php');

if (isset($_GET['action']) && $_GET['action'] !== '') {
  echo 'aucun get';
}else{
  homepage();
}
