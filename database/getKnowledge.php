<?php

include("./database.php");

$sql = "select c.titre, c.code, t.nom as type, c.type_code, c.id_user, u.prenom, u.nom
from connaissances c
join typeCodes t on t.id=type_code
join users u on u.id=c.id_user
where c.id=:id";

$stmt = $db->prepare($sql);
$stmt->execute(array(
        ":id" => $_POST["id"]
));
$connaissance = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($connaissance);