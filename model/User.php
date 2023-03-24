<?php
class User{
    public int $id;
    public string $name;
    public string $firstName;
    public string $email;
    public string $pseudo;
    public string $mdp;
    public int $idRole;

    // public function __construct(string $name, string $firstname, string $email, string $pseudo, string $mdp, int $idRole){
    //     $this->id = $userDb['id'];
    //     $this->name = $userDb['nom'];
    //     $this->firstName = $userDb['prenom'];
    //     $this->email = $userDb['email'];
    //     $this->pseudo = $userDb['pseudo'];
    //     $this->mdp = $userDb['mdp'];
    //     $this->idRole = $userDb['id_role'];
    // }

    public function createToSignin(array $userForm){
        if(!isset($userForm['nom']) && $userForm['nom'] == ''){

            return false;
        }
        if(!isset($userForm['prenom']) && $userForm['prenom'] == ''){

            return false;
        }
        if(!isset($userForm['email']) && $userForm['email'] == ''){

            return false;
        }
        if(!isset($userForm['pseudo']) && $userForm['pseudo'] == ''){
            
            return false;
        }
        if(isset($userForm['mdp']) && strlen($userForm['mdp'])>=4 && $userForm['confirm_mdp'] == $userForm['mdp']){
            $this->mdp = $userForm['mdp'];
        }else{

            return false;
        }

        $this->name = $userForm['nom'];
        $this->firstName = $userForm['prenom'];
        $this->email = $userForm['email'];
        $this->pseudo = $userForm['pseudo'];

        return true;
    }

}

class UserRepository{

    public ?PDO $db = null;
    
    public function logger(){
        var_dump($_POST);
        $_POST['email'];
        $_POST['pseudo'];
        $_POST['mdp'];
    }

    public function findByEmailAndPseudo(string $email, string $pseudo){
        $this->dbConnect($this);
        $req = $this->db->prepare("SELECT * FROM users WHERE email = ? AND pseudo = ?");
        $req->execute([$email,$pseudo]);
        $userDb = $req->fetch();
        if($userDb != false ){
            $user = new User();
            $user->id = $userDb['id'];
            $user->name = $userDb['nom'];
            $user->firstName = $userDb['prenom'];
            $user->email = $userDb['email'];
            $user->pseudo = $userDb['pseudo'];
            $user->mdp = $userDb['mdp'];
            $user->idRole = $userDb['id_role'];
            return $user;
        }else{
            return [];
        }
    }

    public function insertUser(User $user){
        $this->dbConnect($this);
        $req = $this->db->prepare("INSERT INTO users (nom, prenom, email, pseudo, mdp, id_role)
        VALUES (?,?,?,?,?,?)");
        $req->execute([
            $user->name,
            $user->firstName,
            $user->email,
            $user->pseudo,
            $user->mdp,
            2
        ]);
    }

    function dbConnect(UserRepository $userRepository){
        $user = "admin";
        $pass = "root";
        $host = "database";
        $port = '3306';
        $db = "projet_poo";
        if ($userRepository->db === null) {
            $userRepository->db =  new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
    }
}