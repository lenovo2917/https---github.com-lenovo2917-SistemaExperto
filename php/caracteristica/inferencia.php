<?php
include '../helped/db.php';

function inferenciaDirecta($pdo) {
    // Obtener las características seleccionadas
    $stmt = $pdo->query("SELECT id, nombre FROM caracteristicas WHERE id IN (SELECT caracteristica_id FROM raza_caracteristica WHERE bandera = 1)");
    $caracteristicas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($caracteristicas)) {
        return ['success' => false, 'message' => 'No hay características seleccionadas.'];
    }

    // Calcular la suma total de pesos por raza para las características seleccionadas
    $query = "
        SELECT 
            r.id, 
            r.nombre, 
            r.descripcion, 
            GROUP_CONCAT(c.nombre ORDER BY c.nombre SEPARATOR ', ') AS caracteristicas, 
            SUM(rc.peso) AS total_peso_seleccionado, 
            r.peso_total,
            (SUM(rc.peso) / r.peso_total) * 100 AS porcentaje
        FROM 
            raza r
        JOIN 
            raza_caracteristica rc ON r.id = rc.raza_id
        JOIN 
            caracteristicas c ON rc.caracteristica_id = c.id
        WHERE 
            rc.caracteristica_id IN (" . implode(',', array_column($caracteristicas, 'id')) . ") 
            AND rc.bandera = 1
        GROUP BY 
            r.id, r.nombre, r.descripcion, r.peso_total
        ORDER BY 
            total_peso_seleccionado DESC
    ";
    $stmt = $pdo->query($query);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($resultados)) {
        return ['success' => false, 'message' => 'No se encontraron razas con las características seleccionadas.'];
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