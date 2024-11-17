<?php
include '../helped/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $razaId = $_POST['razaId'];

    $query = "
        SELECT c.id, c.nombre
        FROM caracteristicas c
        JOIN raza_caracteristica rc ON c.id = rc.caracteristica_id
        WHERE rc.raza_id = :razaId AND rc.bandera = 0
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['razaId' => $razaId]);
    $faltantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($faltantes);
}
?>
