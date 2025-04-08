<?php
include("./database.php");

$con = true;
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$mdp = $_POST["mdp"];

// Vérifie si un utilisateur avec le même nom et prénom existe déjà
$sql = "SELECT nom, prenom FROM users WHERE nom = :nom AND prenom = :prenom";
$stmt = $db->prepare($sql);
$stmt->execute([
    ":nom" => $nom,
    ":prenom" => $prenom
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $con = false;
    echo json_encode(["success" => false, "message" => "Utilisateur déjà existant"]);
} else {
    // Hash du mot de passe
    $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);

    // Insère le nouvel utilisateur avec le mot de passe hashé
    $sql = "INSERT INTO users (nom, prenom, mdp) VALUES (:nom, :prenom, :mdp)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ":nom" => $nom,
        ":prenom" => $prenom,
        ":mdp" => $hashedPassword
    ]);

    echo json_encode(["success" => true, "message" => "Utilisateur inscrit avec succès"]);
}
?>
