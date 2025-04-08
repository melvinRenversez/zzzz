<?php
session_start();
include("database.php"); // Connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sécurisation et récupération des champs
    $nom = trim($_POST["nom"] ?? '');
    $prenom = trim($_POST["prenom"] ?? '');
    $mdp = trim($_POST["mdp"] ?? '');

    if (!empty($prenom) && !empty($nom) && !empty($mdp)) {
        // Requête pour récupérer l'utilisateur
        $sql = "SELECT * FROM users WHERE nom = :nom AND prenom = :prenom";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ":nom" => $nom,
            ":prenom" => $prenom
        ]);

        $user = $stmt->fetch();

        if ($user && password_verify($mdp, $user["mdp"])) {
            // Authentification réussie
            $_SESSION["user"] = [
                "id" => $user["id"],
                "nom" => $user["nom"],
                "prenom" => $user["prenom"],
                "role" => $user["role"]
            ];

            echo "./accueil.php";
            exit;
        } else {
            echo json_encode(["success" => false, "message" => "Nom, prénom ou mot de passe incorrect."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Champs manquants."]);
    }
}
?>
