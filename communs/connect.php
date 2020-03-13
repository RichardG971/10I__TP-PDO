<?php
$serveur = "localhost";
$user = "root";
$password = "";
$bdd = "tp_php";
$port = "3306";

try
{
    //code...
    $base = new PDO('mysql:host='.$serveur.';port='.$port.';dbname='.$bdd,$user,$password);
    // echo'connexion réussie';
} catch (Exception $e) {
    //throw $th;
    echo $e->getMessage();
}
?>