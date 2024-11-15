<?php
include '../helped/db.php';

// Variable para almacenar el mensaje de resultado
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $id = $_POST['id'] ?? null; // Obtener el ID si existe

    // Verificar si se está intentando eliminar un registro
    if (isset($_POST['accion']) && $_POST['accion'] === 'BAJAS') {
        // Iniciar una transacción
        $pdo->beginTransaction();

        try {
            // Eliminar las raza_caracteristica
            $stmt = $pdo->prepare("DELETE FROM raza WHERE id = (SELECT id FROM raza WHERE nombre = ? AND descripcion = ?)");
            $stmt->execute([$nombre, $descripcion]);

            // Eliminar la raza
            $stmt = $pdo->prepare("DELETE FROM raza WHERE nombre = ? AND descripcion = ?");
            $stmt->execute([$nombre, $descripcion]);

            // Confirmar la transacción
            $pdo->commit();
            $message = 'Registro eliminado con éxito.';
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $pdo->rollBack();
            $message = 'Error al eliminar el registro. Puede que no exista.';
        }
    } 
    
    elseif (isset($_POST['accion']) && $_POST['accion'] === 'MODIFICAR') {
        $id = $_POST['id'];

        // Verificar si el nuevo nombre ya existe, excluyendo el actual
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM raza WHERE nombre = ? AND id != ?");
        $stmt->execute([$nombre, $id]);
        if ($stmt->fetchColumn() > 0) {
            $message = 'El nombre ya existe. Por favor, elija otro nombre.';
        } else {
            // Manejo de la modificación
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $imagenTipo = $_FILES['imagen']['type'];
                $imagenTmp = $_FILES['imagen']['tmp_name'];
                $extensionesPermitidas = ['image/jpeg', 'image/png', 'image/gif'];

                if (in_array($imagenTipo, $extensionesPermitidas)) {
                    $imagenContenido = file_get_contents($imagenTmp);
                    $stmt = $pdo->prepare("UPDATE raza SET nombre = ?, descripcion = ?, imagen = ? WHERE id = ?");
                    $stmt->execute([$nombre, $descripcion, $imagenContenido, $id]);
                } else {
                    $message = 'Tipo de archivo no permitido.';
                }
            } else {
                $stmt = $pdo->prepare("UPDATE raza SET nombre = ?, descripcion = ? WHERE id = ?");
                $stmt->execute([$nombre, $descripcion, $id]);
            }
            $message = 'Registro modificado con éxito.';
        }
    }

    elseif (isset($_FILES['imagen'])) {
        if ($_FILES['imagen']['error'] == 0) {
            // Verificar si el nombre ya existe
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM raza WHERE nombre = ?");
            $stmt->execute([$nombre]);
            if ($stmt->fetchColumn() > 0) {
                $message = 'El nombre ya existe. Por favor, elija otro nombre.';
            } else {
                // Manejo de la imagen e inserción
                $imagenTipo = $_FILES['imagen']['type'];
                $imagenTmp = $_FILES['imagen']['tmp_name'];
                $extensionesPermitidas = ['image/jpeg', 'image/png', 'image/gif'];

                if (in_array($imagenTipo, $extensionesPermitidas)) {
                    $imagenContenido = file_get_contents($imagenTmp);
                    $stmt = $pdo->prepare("INSERT INTO raza (nombre, descripcion, imagen) VALUES (?, ?, ?)");
                    $stmt->execute([$nombre, $descripcion, $imagenContenido]);
                    $message = 'Registro insertado con éxito.';
                } else {
                    $message = 'Tipo de archivo no permitido.';
                }
            }
        } else {
            $message = 'Error al subir la imagen: ' . $_FILES['imagen']['error'];
        }
    } else {
        $message = 'No se ha enviado ningún archivo de imagen.';
    }
}

return $message;
