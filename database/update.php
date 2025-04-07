<?php

include("./database.php");

$titre = $_POST["titre"] ?? '';
$typeCode = $_POST["type_code"] ?? '';
$code = $_POST["code"] ?? '';
$id = $_POST["id"] ?? '';

header('Content-Type: application/json');

if (empty($titre) || empty($typeCode) || empty($code) || empty($id)) {
    echo json_encode(["success" => false, "message" => "Champs manquants"]);
    exit;
}

try {
    $sql = "UPDATE connaissances SET titre = :titre, code = :code, type_code = :type_code WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ":titre" => $titre,
        ":code" => $code,
        ":type_code" => $typeCode,
        ":id" => $id
    ]);

    echo json_encode(["success" => true, "message" => "Connaissance mise à jour"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erreur SQL : " . $e->getMessage()]);
}
