<?php
include '../helped/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caracteristicaId = $_POST['caracteristicaId'];
    $bandera = $_POST['bandera'];

    // Actualizar la bandera de todas las razas que tienen la característica seleccionada
    $query = "UPDATE raza_caracteristica SET bandera = :bandera WHERE caracteristica_id = :caracteristicaId";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['bandera' => $bandera, 'caracteristicaId' => $caracteristicaId]);

    echo json_encode(['success' => true]);
}
?>