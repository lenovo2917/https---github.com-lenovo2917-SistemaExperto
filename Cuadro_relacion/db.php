<?php
// base de datos-----------

$host = 'localhost'; 
$dbname = 'sistema_experto';
$user = 'root'; 
$pass = ''; 

// Crear la conexión MySQLi
$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos.']));
}
?>
