<?php
header('Content-Type: application/json'); // Asegúrate de que el tipo de contenido sea JSON

include './db.php';

if ($conn->connect_error) {
    // Manejo de error de conexión
    die(json_encode(['error' => 'Error de conexión a la base de datos']));
}

// Consulta para obtener razaes y síntomas
$query_razaes = "SELECT id, nombre, imagen FROM raza"; 
$query_caracteristicas = "SELECT id, nombre FROM caracteristicas"; 

$result_razaes = $conn->query($query_razaes);
$result_caracteristicas = $conn->query($query_caracteristicas);

$razaes = [];
$caracteristicas = [];

// Verificar resultados de razaes
if ($result_razaes) {
    while ($row = $result_razaes->fetch_assoc()) {
        // Codificar la imagen a base64
        $row['imagen'] = base64_encode($row['imagen']); // Codificar la imagen en base64
        $row['imagen'] = 'data:image/jpeg;base64,' . $row['imagen']; // Prepend la cadena base64 con el tipo MIME
        $razaes[] = $row; // Agregar la raza al array
    }
}

// Verificar resultados de síntomas
if ($result_caracteristicas) {
    while ($row = $result_caracteristicas->fetch_assoc()) {
        $caracteristicas[] = $row; // Agregar el síntoma al array
    }
}

// Crear el array de respuesta
$data = [
    'razaes' => $razaes,
    'caracteristicas' => $caracteristicas,
];

// Cerrar la conexión
$conn->close();

echo json_encode($data); // Enviar la respuesta en formato JSON
?>
