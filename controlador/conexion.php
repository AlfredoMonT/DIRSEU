<?php
// Datos de conexión
$host = "127.0.0.1"; 
$user = "root"; 
$password = "";
$dbname = "bdtalleres";
// Crear la conexión

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$conn->set_charset("utf8");

?>
