<?php
session_start();
include("database.php"); // Connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sécurisation et récupération du champ 'prenom'
    $nom = trim($_POST["nom"] ?? '');
    $prenom = trim($_POST["prenom"] ?? '');
    $mdp = trim($_POST["mdp"] ?? '');

    if (!empty($prenom)) {
        // Requête préparée pour éviter les injections SQL
        $sql = "SELECT * FROM users WHERE nom = :nom and prenom = :prenom and mdp = :mdp";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(
            ":nom" => $nom,
            ":prenom" => $prenom,
            ":mdp" => $mdp
        ));

        $user = $stmt->fetch();

        if ($user) {
            // Stockage des infos utilisateur en session
            $_SESSION["user"] = [
                "id" => $user["id"],
                "nom" => $user["nom"],
                "prenom" => $user["prenom"],
                "role" => $user["role"]
            ];

            echo "./accueil.php"; // Tu pourrais aussi faire un `header("Location: accueil.php")` selon ton système
            exit;
        }
    }
}
