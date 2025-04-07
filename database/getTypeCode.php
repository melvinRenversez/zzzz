<?php

include("./database.php");

$sql = "SELECT id, nom FROM typeCodes order by nom asc";

$stmt = $db->prepare($sql);
$stmt->execute();
$typecodes = $stmt->fetchAll();

header("Content-Type: application/json");
echo json_encode($typecodes);