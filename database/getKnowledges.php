<?php

include("./database.php");

$mc = $_POST["mc"] ?? '';  // Définit une chaîne vide si mc est vide ou non définie
$user = $_POST["user"] ?? ''; // Définit une chaîne vide si user est vide ou non définie
$tc = $_POST["tc"] ?? '';  // Définit une chaîne vide si tc est vide ou non définie

// Construction de la requête SQL avec les conditions dynamiques
$sql = "
SELECT c.id, c.titre, c.code, t.nom as type_code, u.prenom as auteurP, u.nom as auteurN, c.date_update as date
FROM connaissances c
    JOIN typeCodes t ON t.id = c.type_code
    JOIN users u ON u.id = c.id_user
WHERE 1=1 "; // On commence avec une condition toujours vraie

// Ajout des conditions dynamiques
if (!empty($mc)) {
    $sql .= " AND c.titre LIKE :mc";
}
if (!empty($user)) {
    $sql .= " AND u.id = :user";
}
if (!empty($tc)) {
    $sql .= " AND c.type_code = :tc";
}

$sql .= " ORDER BY date_update DESC;";

$stmt = $db->prepare($sql);

// Ajout des paramètres conditionnels
$params = [];
if (!empty($mc)) {
    $params[":mc"] = "%" . $mc . "%";
}
if (!empty($user)) {
    $params[":user"] = $user;
}
if (!empty($tc)) {
    $params[":tc"] = $tc;
}

$stmt->execute($params);
$codes = $stmt->fetchAll();

header("Content-Type: application/json");
echo json_encode($codes);
