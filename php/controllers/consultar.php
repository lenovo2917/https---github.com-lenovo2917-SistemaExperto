<?php
include '../helped/db.php';

header('Content-Type: application/json');

// Verificar el tipo de consulta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['tipoConsulta'] === 'general') {
        // Consulta general: obtener todos los registros
        $stmt = $pdo->prepare("SELECT id, nombre, descripcion, imagen FROM raza");
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Convertir la imagen a base64
        foreach ($resultados as &$fila) {
            $fila['imagen'] = base64_encode($fila['imagen']);
        }

        echo json_encode($resultados);
    } elseif ($_POST['tipoConsulta'] === 'individual' && isset($_POST['id'])) {
        // Consulta individual: obtener el registro por ID
        $stmt = $pdo->prepare("SELECT id, nombre, descripcion, imagen FROM raza WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            // Convertir la imagen a base64
            $resultado['imagen'] = base64_encode($resultado['imagen']);
            echo json_encode($resultado);
        } else {
            echo json_encode(null);
        }
    }
}
?>
