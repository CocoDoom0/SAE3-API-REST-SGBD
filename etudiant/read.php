<?php
// Headers requis
// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");
// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");
// Méthode autorisée
header("Access-Control-Allow-Methods: GET");
// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");
// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // La bonne méthode est utilisée
    include_once '../config/database.php';
    include_once '../models/etudiant.php';

    // On instancie la base de données
    $database = new database();
    $db = $database->getConnexion();

    // On instancie les etudiants
    $etudiant = new etudiant($db);

    // On récupère les données
    $stmt = $etudiant->read();

    // On verifie si on a au moins 1 étudiant
if($stmt->rowCount() > 0) {
    // On initialise un tableau associatif
    $tableauEtudiant = [];
    $tableauEtudiant['etudiant'] = [];

    // On parcourt les etudiants
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $etud = [
            "idEtudiant" => $idEtudiant,
            "nom" => $nom,
            "prenom" => $prenom,
            "parcours" => $parcours,
            "idDemiGroupe" => $idDemiGroupe,
        ];

        $tableauEtudiant['etudiant'][] = $etud;
    }
    // On envoie le code réponse 200 OK
    http_response_code(200);

    // On encode en json et on envoie
    echo json_encode($tableauEtudiant);
    }
}else{
    // Mauvaise méthode, on gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
?>
