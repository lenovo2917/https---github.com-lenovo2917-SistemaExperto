<?php
include './db.php';

// Configurar cabeceras para aceptar JSON
header('Content-Type: application/json');

// Leer los datos enviados desde JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si los datos necesarios están presentes
if (isset($data['raza_id']) && isset($data['caracteristicas']) && isset($data['pesos'])) {
    $raza_id = $data['raza_id'];
    $caracteristicas = $data['caracteristicas']; // Array de síntomas
    $pesos = $data['pesos'];       // Array de pesos

    // Preparar una respuesta
    $response = [
        'status' => 'error',
        'message' => 'No se pudo guardar la relación.'
    ];

    // Iniciar la transacción
    $conn->begin_transaction();

    try {
        // Iterar sobre cada síntoma para guardarlo en la tabla de relación
        for ($i = 0; $i < count($caracteristicas); $i++) {
            $caracteristica_id = $caracteristicas[$i];
            $peso = $pesos[$i];

            // Preparar la consulta para insertar la relación en la base de datos
            $sql = "INSERT INTO raza_caracteristica (raza_id, caracteristica_id, peso) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iid', $raza_id, $caracteristica_id, $peso); // 'iid' significa entero, entero, decimal

            if (!$stmt->execute()) {
                throw new Exception("Error al insertar la relación: " . $stmt->error);
            }
        }

        // Confirmar la transacción
        $conn->commit();

        // Enviar una respuesta de éxito
        $response['status'] = 'success';
        $response['message'] = 'Relaciones guardadas exitosamente.';
    } catch (Exception $e) {
        // Si hay algún error, revertir la transacción
        $conn->rollback();

        // Enviar un mensaje de error
        $response['message'] = $e->getMessage();
    }

    // Cerrar la conexión y el statement
    $stmt->close();
    $conn->close();

    // Enviar la respuesta final en formato JSON
    echo json_encode($response);
} else {
    // Enviar una respuesta de error si faltan datos
    echo json_encode([
        'status' => 'error',
        'message' => 'Datos incompletos.'
    ]);
}
?>
