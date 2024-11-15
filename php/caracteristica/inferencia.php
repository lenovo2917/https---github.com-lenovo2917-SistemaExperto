<?php
include '../helped/db.php';

function inferenciaDirecta($pdo) {
    // Obtener las características seleccionadas
    $stmt = $pdo->query("SELECT id, nombre FROM caracteristicas WHERE id IN (SELECT caracteristica_id FROM raza_caracteristica WHERE bandera = 1)");
    $caracteristicas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($caracteristicas)) {
        return ['success' => false, 'message' => 'No hay características seleccionadas.'];
    }

    // Mostrar las características seleccionadas en la consola
    error_log("Características seleccionadas:");
    foreach ($caracteristicas as $caracteristica) {
        error_log("ID: " . $caracteristica['id'] . ", Nombre: " . $caracteristica['nombre']);
    }

    // Calcular la suma total de pesos por raza para las características seleccionadas
    $query = "
        SELECT r.id, r.nombre, SUM(rc.peso) AS total_peso_seleccionado, r.peso_total
        FROM raza r
        JOIN raza_caracteristica rc ON r.id = rc.raza_id
        WHERE rc.caracteristica_id IN (" . implode(',', array_column($caracteristicas, 'id')) . ") AND rc.bandera = 1
        GROUP BY r.id, r.nombre, r.peso_total
        ORDER BY total_peso_seleccionado DESC
    ";
    $stmt = $pdo->query($query);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($resultados)) {
        return ['success' => false, 'message' => 'No se encontraron razas con las características seleccionadas.'];
    }

    // Calcular el porcentaje de similitud usando una regla de tres
    foreach ($resultados as &$resultado) {
        // Obtener el total de pesos de las características seleccionadas para la raza actual
        $stmt_peso_seleccionado = $pdo->prepare("
            SELECT SUM(rc.peso) AS total_peso_seleccionado
            FROM raza_caracteristica rc
            WHERE rc.raza_id = ? AND rc.caracteristica_id IN (" . implode(',', array_column($caracteristicas, 'id')) . ") AND rc.bandera = 1
        ");
        $stmt_peso_seleccionado->execute([$resultado['id']]);
        $peso_seleccionado = $stmt_peso_seleccionado->fetch(PDO::FETCH_ASSOC)['total_peso_seleccionado'];

        if ($resultado['peso_total'] > 0) {
            $resultado['porcentaje'] = ($peso_seleccionado / $resultado['peso_total']) * 100;
        } else {
            $resultado['porcentaje'] = 0;
        }

        // Mostrar los cálculos en la consola
        error_log("Raza: " . $resultado['nombre']);
        error_log("Total Peso Seleccionado: " . $peso_seleccionado);
        error_log("Peso Total: " . $resultado['peso_total']);
        error_log("Porcentaje: " . $resultado['porcentaje'] . "%");
    }

    // Ordenar los resultados por porcentaje de mayor a menor
    usort($resultados, function($a, $b) {
        return $b['porcentaje'] <=> $a['porcentaje'];
    });

    return ['success' => true, 'resultados' => $resultados];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = inferenciaDirecta($pdo);
    echo json_encode($response);
}
?>