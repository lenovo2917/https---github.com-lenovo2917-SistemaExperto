<?php
include '../helped/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $razaId = $_POST['razaId'];
    $faltantes = $_POST['faltantes']; // Lista de IDs de características faltantes

    foreach ($faltantes as $caracteristicaId) {
        $query = "UPDATE raza_caracteristica SET bandera = 1 WHERE raza_id = :razaId AND caracteristica_id = :caracteristicaId";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['razaId' => $razaId, 'caracteristicaId' => $caracteristicaId]);
    }

    echo json_encode(['success' => true, 'message' => 'Pesos actualizados.']);
}
?>
