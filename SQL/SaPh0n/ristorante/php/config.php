<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "GestioneRistorante_5Q";

// Create connection
$connessione = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connessione->connect_error) {
    die("Connection failed: " . $connessione->connect_error);
}
?>  