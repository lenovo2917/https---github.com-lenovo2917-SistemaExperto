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

    // Calcular el porcentaje de coincidencia para cada raza
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
            rc.caracteristica_id IN (SELECT caracteristica_id FROM raza_caracteristica WHERE bandera = 1)
            AND rc.bandera = 1
        GROUP BY 
            r.id, r.nombre, r.descripcion, r.peso_total
        ORDER BY 
            total_peso_seleccionado DESC
    ";
    $stmt = $pdo->query($query);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ordenar los resultados por porcentaje de mayor a menor
    usort($resultados, function($a, $b) {
        return $b['porcentaje'] <=> $a['porcentaje'];
    });

    echo json_encode(['success' => true, 'resultados' => $resultados]);
}
?>