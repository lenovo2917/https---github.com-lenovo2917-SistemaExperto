<?php
include './db.php';

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

// Borrar la relación
if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM raza_caracteristica WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Eliminación exitosa.";
        } else {
            echo "Error al eliminar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la declaración: " . $conn->error;
    }
} else {
    echo "ID no válido.";
}

$conn->close();
?>
