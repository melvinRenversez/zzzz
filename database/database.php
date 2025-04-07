<?php

$host = "localhost";
$dbname = "baseConnaissances";
$username = "root"; 
$dbpassword = "mysqlpassword"; 


try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $dbpassword);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
} catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
}
