<?php
Class database{
    private $host = "localhost";
    private $db_name = "sae3";
    private $username = "root";
    private $password = "root";
    public $connexion;

    //Getter pour connexion
    public function getConnexion(){
        //On ferme la connexion pour ne pas avoir de conflit
        $this->connexion=null;

        //On essaie de se connecter
        try{
            $this->connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->connexion->exec("set names utf8"); // On force les transactions en UTF-8
        }catch(PDOException $exception){ // On gère les erreurs éventuelles
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->connexion;
    }
}
?>