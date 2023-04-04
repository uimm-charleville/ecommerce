<?php
/** 
* cette classe permet de mettre en place les users
*/
class User{
    public int $id;
    public string $name;
    public string $firstName;
    public string $email;
    public string $pseudo;
    public string $mdp;
    public int $idRole;


    /**
    * Cette fonction prend en parametre un tableau venant d'un formulaire ($_post)
    * @param array $userForm le tableau venant d'un formulaire
    * @return bool si c'est pas bon retourne false sinon true
    */
    public function createToSignin(array $userForm):bool{
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

/**
* cette classe permet de gerer les users en base de donnée 
*/
class UserRepository{

    public ?PDO $db = null;

    /**
    * Cette fonction va retourner un user de la base de donnée trouvé par son email et son pseuudo
    * Si on trouve un user on retouurne un type user sinon un tableau vide
    * @param string $email un email
    * @param string $pseudo un pseudo
    * @return User le user venant de la base de donée
    * @return array tableau vide si aucun user est trouvé
    */
    public function findByEmailAndPseudo(string $email, string $pseudo):User|array{
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

    /**
    * Cette fonction insert le user en paramètre dans la base de donnée 
    * @param User $user le user a insérer dans la base de donnée
    */
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

    /**
    * Cette fonction permet de se connecter a la base de donnée
    * @param UserRepository $userRepository notre repository
    */
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