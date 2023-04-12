<?php
require_once('config/Connect_bddClass.php');
class User{
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $pseudo;
    public $mdp;
    public $id_role;
}

class UserRepository extends Connect_bdd{
    public function __construct(){
        parent::__construct();
    }

    public function getUserByEmailAndPseudo($email,$pseudo){
        $req = $this->bdd->prepare('SELECT * FROM users WHERE email = ? AND pseudo = ?');
        $req->execute([$email,$pseudo]);
        $data = $req->fetch();
        if($data != false){
            $user = new User();
            $user->id = $data['id'] ;
            $user->nom = $data['nom'];
            $user->prenom = $data['prenom'];
            $user->email = $data['email'];
            $user->pseudo = $data['pseudo'];
            $user->mdp = $data['mdp'];
            $user->id_role = $data['id_role'];

            return $user;
        }else{
            
            return [];
        }
    }
}


?>