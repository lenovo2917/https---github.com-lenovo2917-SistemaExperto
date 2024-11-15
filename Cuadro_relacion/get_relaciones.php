<?php
header('Content-Type: application/json'); // Asegúrate de que el tipo de contenido sea JSON

include './db.php';

if ($conn->connect_error) {
    // Manejo de error de conexión
    die(json_encode(['error' => 'Error de conexión a la base de datos']));
}

$raza_id = isset($_GET['raza_id']) ? intval($_GET['raza_id']) : 0;

if ($raza_id > 0) {
    // Consulta para obtener las características de la raza
    $query = "
        SELECT rc.id, c.nombre AS caracteristica, rc.peso
        FROM raza_caracteristica rc
        JOIN caracteristicas c ON rc.caracteristica_id = c.id
        WHERE rc.raza_id = $raza_id
    ";

    $result = $conn->query($query);

    $caracteristicas = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $caracteristicas[] = $row;
        }
    }

    echo json_encode($caracteristicas);
} else {
    echo json_encode(['error' => 'ID de raza no válido']);
}

// Cerrar la conexión
$conn->close();
?>
