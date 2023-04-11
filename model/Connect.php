<?php

class Connect{
    public ?PDO $db = null;

    public function __construct() {
        $user = "admin";
        $pass = "root";
        $host = "database";
        $port = '3306';
        $db = "projet_poo";
        $this->db =  new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    }  
}
?>