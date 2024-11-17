<?php
include '../helped/db.php';

if (isset($_POST['reset']) && $_POST['reset'] == true) {
    // Restablecer todas las banderas a 0 en raza_caracteristica
    $stmt = $pdo->prepare("UPDATE raza_caracteristica SET bandera = 0");
    $stmt->execute();
} else if (isset($_POST['id']) && isset($_POST['bandera'])) {
    // Actualizar la bandera de una característica específica en raza_caracteristica
    $id = $_POST['id'];
    $bandera = $_POST['bandera'];
    $stmt = $pdo->prepare("UPDATE raza_caracteristica SET bandera = ? WHERE caracteristica_id = ?");
    $stmt->execute([$bandera, $id]);
}
?>
