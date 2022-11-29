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
    include_once '../config/database.php';
    include_once '../models/etudiant.php';

    // On instancie la base de données
    $database = new database();
    $db = $database->getConnexion();
    // On instancie les etudiants
    $etudiant = new etudiant($db);

    //On recupere les informations mis en data grace a POST
    $donnees = json_decode(json_encode(array("idEtudiant" => (intval($_POST["idEtudiant"])))));


    if(!empty($donnees->idEtudiant)){
        $etudiant->idEtudiant = $donnees->idEtudiant;

        // On récupère le produit
        $etudiant->readOne();

        // On vérifie si le produit existe
        if($etudiant->nom != null){

            $prod = [
                "idEtudiant" => $etudiant->idEtudiant,
                "nom" => $etudiant->nom,
                "prenom" => $etudiant->prenom,
                "parcours" => $etudiant->parcours,
                "idDemiGroupe" => $etudiant->idDemiGroupe,
            ];

            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($prod);
        }else{
            // 404 Not found
            http_response_code(404);

            echo json_encode(array("message" => "Le produit n'existe pas."));
        }

    }else{
        // 404 Not found
        http_response_code(404);

        echo json_encode(array("message" => "Le produit n'existe pas."));
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
?>
