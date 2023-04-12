<?php
require_once('config/Connect_bddClass.php');

class Image{

}


class ImageRepository extends Connect_bdd{

    public function __construct(){
        parent::__construct();
    }

    public function getImageByProductId($productId){
        $req =  $this->bdd-prepare();
        $image = new Image();

        return $image;
    }
}
?>
