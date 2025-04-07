<?php

session_start();
if ( !isset($_SESSION["user"])){
        header("Location:../index.php");
        exit();
}

include("./database.php");

$id = $_SESSION["user"]["id"];

if ( isset( $_POST ) ){
        var_dump( $_POST );

        $titre = $_POST["titre"];
        $typeCode = $_POST["type_code"];
        $code = $_POST["code"];

        echo $typeCode . " " . $code . " " . $titre ;

        $sql = "INSERT INTO connaissances (titre, code, type_code, id_user) values (:titre, :code, :type_code, :id_user)";

        $stmt = $db->prepare( $sql );


        $stmt->execute( array( 
                ":titre" => $titre,
                ":code" => $code,
                ":type_code" => $typeCode,
                ":id_user" => $id
         ) );
        echo "Nouvelle connaissance ajoutée avec succès";

        header("Location: ../accueil.php");

}