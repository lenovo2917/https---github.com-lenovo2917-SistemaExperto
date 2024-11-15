<?php
include '../../php/helped/db.php';

$id = isset($_POST['id']) ? (int) $_POST['id'] : null;
$direccion = $_POST['direccion'] ?? 'INICIO';

// Función para obtener el registro basado en la dirección y el ID actual
function obtenerRegistro($id = null, $direccion = 'INICIO') {
    global $pdo;

    if ($direccion === 'INICIO') {
        $query = "SELECT * FROM raza ORDER BY id ASC LIMIT 1";
    } elseif ($direccion === 'FINAL') {
        $query = "SELECT * FROM raza ORDER BY id DESC LIMIT 1";
    } elseif ($direccion === 'ADELANTE') {
        $query = "SELECT * FROM raza WHERE id > :id ORDER BY id ASC LIMIT 1";
    } elseif ($direccion === 'ATRAS') {
        $query = "SELECT * FROM raza WHERE id < :id ORDER BY id DESC LIMIT 1";
    }

    $stmt = $pdo->prepare($query);

    if ($id && ($direccion === 'ADELANTE' || $direccion === 'ATRAS')) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$registro = obtenerRegistro($id, $direccion);

if ($registro) {
    echo json_encode([
        'id' => $registro['id'],
        'nombre' => $registro['nombre'],
        'descripcion' => $registro['descripcion'],
        'imagen' => base64_encode($registro['imagen'])
    ]);
} else {
    echo json_encode(null);
    // Imprimir ID y dirección para depuración
    error_log("ID recibido: $id");
    error_log("Dirección: $direccion");
}
?>
