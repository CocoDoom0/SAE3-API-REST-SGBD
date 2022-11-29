<?php
    Class etudiant{
        //Connexion
        private $connexion;
        //Table demander
        private $table = "etudiant";

        //Propriétés de la table
        public $idEtudiant;
        public $nom;
        public $prenom;
        public $parcours;
        public $idDemiGroupe;

        /**
         * Constructeur avec $db pour la connexion à la base de données
         *
         * @param $db
         */
        public function __construct($db){
            $this->connexion = $db;
        }

        //--CRUD--//

        /**
         * Créer un nouvel étudiant
         *
         * @return void
         */
        public function create(){


            // AJOUT CONTRAINTE POUR PARCOURS A FAIRE


            //Ecriture de la requête SQL
            $sql = "INSERT INTO ". $this->table . " SET nom=:nom, prenom=:prenom, parcours=:parcours, idDemiGroupe=:idDemiGroupe";

            //Preparation de la requête
            $query = $this->connexion->prepare($sql);

            //Anti injection
            $this->nom=htmlspecialchars(strip_tags($this->nom));
            $this->prenom=htmlspecialchars(strip_tags($this->prenom));
            $this->parcours=htmlspecialchars(strip_tags($this->parcours));
            $this->idDemiGroupe=htmlspecialchars(strip_tags($this->idDemiGroupe));

            //Ajout des données protégées
            $query->bindParam(":nom",$this->nom);
            $query->bindParam(":prenom",$this->prenom);
            $query->bindParam(":parcours",$this->parcours);
            $query->bindParam(":idDemiGroupe",$this->idDemiGroupe);

            // Exécution de la requête
            if($query->execute()){
                return true;
            }
            return false;


        }

        /**
         * Lecture de tout les etudiants
         *
         * @return void
         */
        public function read(){
            //Ecriture de la requête SQL
            $sql = "SELECT * FROM ". $this->table;

            //Preparation de la requête
            $query = $this->connexion->prepare($sql);

            //Exécution de la requête
            $query->execute();

            // On retourne le résultat
            return $query;
        }

        /**
         * Lecture d'un etudiant
         *
         * @return void
         */
        public  function readOne(){
            //Ecriture de la requête SQL
            $sql = "SELECT * FROM ". $this->table ." WHERE idEtudiant = ?";

            //Preparation de la requête
            $query = $this->connexion->prepare($sql);

            // On attache l'id
            $query->bindParam(1, $this->idEtudiant);

            //Exécution de la requête
            $query->execute();

            // on récupère la ligne
            $row = $query->fetch(PDO::FETCH_ASSOC);

            $this->nom = $row['nom'];
            $this->prenom = $row['prenom'];
            $this->parcours = $row['parcours'];
            $this->idDemiGroupe = $row['idDemiGroupe'];
        }

        /**
         * Mettre à jour un étudiant
         *
         * @return void
         */
        public function update(){

            // AJOUT CONTRAINTE POUR PARCOURS A FAIRE

            //Ecriture de la requête SQL
            $sql = "UPDATE ". $this->table ." SET nom = :nom, prenom = :prenom, parcours = :parcours, idDemiGroupe = :idDemiGroupe WHERE idEtudiant = :idEtudiant";

            //Preparation de la requête
            $query = $this->connexion->prepare($sql);

            //Anti injection
            $this->nom=htmlspecialchars(strip_tags($this->nom));
            $this->prenom=htmlspecialchars(strip_tags($this->prenom));
            $this->parcours=htmlspecialchars(strip_tags($this->parcours));
            $this->idDemiGroupe=htmlspecialchars(strip_tags($this->idDemiGroupe));

            //Ajout des données protégées
            $query->bindParam(":nom",$this->nom);
            $query->bindParam(":prenom",$this->prenom);
            $query->bindParam(":parcours",$this->parcours);
            $query->bindParam(":idDemiGroupe",$this->idDemiGroupe);
            $query->bindParam(":idEtudiant",$this->idEtudiant);

            // Exécution de la requête
            if($query->execute()){
                return true;
            }
            return false;
        }

        /**
         * Supprimer un étudiant
         *
         * @return void
         */
        public function delete(){
            //Ecriture de la requête SQL
            $sql = "DELETE FROM " . $this->table . " WHERE idEtudiant = ?";

            //Preparation de la requête
            $query = $this->connexion->prepare( $sql );

            //Anti injection
            $this->id=htmlspecialchars(strip_tags($this->idEtudiant));

            // On attache l'id
            $query->bindParam(1, $this->idEtudiant);

            // Exécution de la requête
            if($query->execute()){
                return true;
            }

            return false;
        }
    }


?>