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

public function createToSignin(array $userForm):bool{
        if(!isset($userForm['nom']) OR $userForm['nom'] == ''){
            
            return false;
        }
        if(!isset($userForm['prenom']) OR $userForm['prenom'] == ''){
     
            return false;
        }
        if(!isset($userForm['email']) OR $userForm['email'] == ''){

            return false;
        }
        if(!isset($userForm['pseudo']) OR $userForm['pseudo'] == ''){
            
            return false;
        }
        if(isset($userForm['mdp']) OR strlen($userForm['mdp'])>=4 && $userForm['confirm_mdp'] == $userForm['mdp']){

            $this->mdp = $userForm['mdp'];
        }else{

            return false;
        }

        $this->nom = $userForm['nom'];
        $this->prenom = $userForm['prenom'];
        $this->email = $userForm['email'];
        $this->pseudo = $userForm['pseudo'];

        return true;
    }

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

    public function getUserByPseudo($pseudo){
        $req = $this->bdd->prepare('SELECT * FROM users WHERE pseudo = ?');
        $req->execute([$pseudo]);
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

    public function getUserByEmail($email){
        $req = $this->bdd->prepare('SELECT * FROM users WHERE email = ?');
        $req->execute([$email]);
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

    public function insertUser(User $user){
        $req = $this->bdd->prepare("INSERT INTO users (nom, prenom, email, pseudo, mdp, id_role)
        VALUES (?,?,?,?,?,?)");
        $req->execute([
            $user->nom,
            $user->prenom,
            $user->email,
            $user->pseudo,
            $user->mdp,
            2
        ]);
    } 
}


?>