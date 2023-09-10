<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "venator";

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}
?>
