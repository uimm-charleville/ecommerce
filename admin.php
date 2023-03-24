<?php
require_once('controller/adminController.php');
if(isset($_GET['action']) && $_GET['action'] !== '') {

}else{
    admin();
}