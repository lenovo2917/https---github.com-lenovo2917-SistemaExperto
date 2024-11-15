<?php
header('Content-Type: application/json');
include '../helped/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['tipoConsulta'] === 'general') {
        // Consulta general: obtener todos los registros
        $stmt = $pdo->prepare("SELECT id, nombre, imagen FROM caracteristicas");
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Verificar si se obtuvieron resultados
        if ($resultados) {
            // Convertir la imagen a base64
            foreach ($resultados as &$fila) {
                $fila['imagen'] = base64_encode($fila['imagen']);
            }
            echo json_encode($resultados);
        } else {
            echo json_encode(['error' => 'No se encontraron síntomas.']);
        }
    } elseif ($_POST['tipoConsulta'] === 'individual' && isset($_POST['id'])) {
        // Consulta individual: obtener el registro por ID
        $stmt = $pdo->prepare("SELECT id, nombre, imagen FROM caracteristicas WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            // Convertir la imagen a base64
            $resultado['imagen'] = base64_encode($resultado['imagen']);
            echo json_encode($resultado);
        } else {
            echo json_encode(['error' => 'No se encontró un síntoma con ese ID.']);
        }
    } else {
        echo json_encode(['error' => 'Tipo de consulta no válido o ID no proporcionado.']);
    }
} else {
    echo json_encode(['error' => 'Método de solicitud no válido.']);
}
?>
