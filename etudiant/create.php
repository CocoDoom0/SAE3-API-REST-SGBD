<?php
// Headers requis
// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");

// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");

// Méthode autorisée
header("Access-Control-Allow-Methods: POST");

// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");

// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // La bonne méthode est utilisée
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/etudiant.php';

    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnexion();

    // On instancie les etudiants
    $etudiant = new etudiant($db);

    // On récupère les données reçues
    $donnees = json_decode(file_get_contents("php://input"));

    // On vérifie qu'on a bien toutes les données
    if(!empty($donnees->nom) && !empty($donnees->prenom) && !empty($donnees->parcours) && !empty($donnees->idDemiGroupe)){
        $validParcours = ["A","B","C"];
        $validDemiGroupe = ["1.1","1.2","2.1","2.2","3.1","3.2","4.1","4.2","5.1","5.2"];
        if(in_array($donnees->parcours,$validParcours) && in_array($donnees->idDemiGroupe,$validDemiGroupe)){
            $etudiant->nom = $donnees->nom;
            $etudiant->prenom = $donnees->prenom;
            $etudiant->parcours = $donnees->parcours;
            $etudiant->idDemiGroupe = $donnees->idDemiGroupe;

            if($etudiant->create()){
                // Ici la création a fonctionné
                // On envoie un code 201
                http_response_code(201);
                echo json_encode(["message" => "L'ajout a été effectué"]);
            }else{
                // Ici la création n'a pas fonctionné
                // On envoie un code 503
                http_response_code(503);
                echo json_encode(["message" => "L'ajout n'a pas été effectué"]);
            }
        }else{
            // Ici la création n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "L'ajout n'a pas été effectué"]);
        }
    }else{
        // Ici la création n'a pas fonctionné
        // On envoie un code 503
        http_response_code(503);
        echo json_encode(["message" => "Les données saisie ne sont pas bonnes"]);
    }

}else{
    // Mauvaise méthode, on gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}