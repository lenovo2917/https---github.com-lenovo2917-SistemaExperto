<?php
include '../helped/db.php';

function obtenerExplicacion($pdo, $razaId) {
    // Obtener las características seleccionadas
    $stmt = $pdo->prepare("SELECT c.nombre FROM caracteristicas c JOIN raza_caracteristica rc ON c.id = rc.caracteristica_id WHERE rc.raza_id = :raza_id AND rc.bandera = 1");
    $stmt->execute(['raza_id' => $razaId]);
    $caracteristicas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($caracteristicas)) {
        return ['success' => false, 'message' => 'No hay características seleccionadas.'];
    }

    // Obtener la raza
    $stmt = $pdo->prepare("SELECT nombre FROM raza WHERE id = :raza_id");
    $stmt->execute(['raza_id' => $razaId]);
    $raza = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$raza) {
        return ['success' => false, 'message' => 'No se encontró la raza.'];
    }

    // Generar la explicación
    $explicacion = "La raza más probable es " . $raza['nombre'] . " debido a las siguientes características seleccionadas: ";
    $explicacion .= implode(", ", array_column($caracteristicas, 'nombre')) . ".";

    return ['success' => true, 'explicacion' => $explicacion];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['raza_id'])) {
        $response = obtenerExplicacion($pdo, $_POST['raza_id']);
        echo json_encode($response);
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos insuficientes.']);
    }
}
?>