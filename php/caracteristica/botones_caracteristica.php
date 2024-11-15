<?php
require_once '../helped/db.php'; // Asegúrate de que la conexión a la base de datos esté incluida

// Función para obtener un registro específico
function obtenerRegistro($id = null, $direccion = 'INICIO') {
    global $pdo;

    // Si no se proporciona un ID, establecer uno por defecto según la dirección
    if ($id === null) {
        if ($direccion === 'INICIO') {
            $query = "SELECT * FROM caracteristicas ORDER BY id ASC LIMIT 1";
        } elseif ($direccion === 'FINAL') {
            $query = "SELECT * FROM caracteristicas ORDER BY id DESC LIMIT 1";
        } else {
            return null; // Retornar null si no se puede determinar un ID
        }
    } else {
        // Si se proporciona un ID, ajustar las consultas
        if ($direccion === 'ADELANTE') {
            $query = "SELECT * FROM caracteristicas WHERE id > :id ORDER BY id ASC LIMIT 1";
        } elseif ($direccion === 'ATRAS') {
            $query = "SELECT * FROM caracteristicas WHERE id < :id ORDER BY id DESC LIMIT 1";
        } else {
            return null; // Retornar null si la dirección no es válida
        }
    }

    $stmt = $pdo->prepare($query);
    
    if ($id !== null) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Obtener el primer registro al cargar la página
$registroActual = obtenerRegistro();
?>