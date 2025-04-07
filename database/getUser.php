<?php

include("./database.php");

$sql = "select id, nom, prenom from users";

$stmt = $db->query($sql);
$users = $stmt->fetchAll();

header("Content-Type: application/json");
echo json_encode($users);