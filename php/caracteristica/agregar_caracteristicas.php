<script src="../../js/navegar_caracteristica.js"></script>

<?php
include '../helped/db.php';
session_start();  // Iniciar la sesión

// Capturar el mensaje desde la sesión
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);

include '../caracteristica/botones_caracteristica.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&family=Montagu+Slab:wght@100..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../../css/main.css">
    <title>Login de Usuarios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container mt-4">
        <h1 class="text-center mb-4">SINTOMAS</h1>

        <div aria-live="polite" aria-atomic="true" class="position-relative">
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <!-- Toast para selección de consulta -->
                <div id="opcionConsultaToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Tipo de Consulta</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body" style="background-color: white; color: black;">
                        ¿Qué tipo de consulta deseas realizar?
                        <div class="mt-2 pt-2 border-top">
                            <button type="button" class="btn btn-primary btn-sm" onclick="consultaGeneral()">Consulta
                                General</button>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="preguntarID()">Consulta
                                Individual</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal para mostrar el resultado de la consulta individual -->
        <div class="modal fade" id="consultaModal" tabindex="-1" aria-labelledby="consultaModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="consultaModalLabel">Resultado de la Consulta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="contenidoModal">
                        <!-- Aquí se mostrarán los resultados -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


        <form method="POST" enctype="multipart/form-data" action="./CRUD_caracteristica.php">
            <input type="hidden" name="id" value="<?= $registroActual['id'] ?? 0 ?>"> <!-- Campo oculto para el ID -->

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $registroActual['nombre'] ?? ''
                         ?>" data-id="<?= $registroActual['id'] ?? 0 ?> " style="font-size: 20px;">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="border p-3 text-center" style="width: 100%; height: auto;">
                        <label for="imagen" class="form-label">Seleccionar Imagen:</label>
                        <input style="font-size: 20px;" type="file" class="form-control mb-3" id="imagen" name="imagen"
                            accept="image/*" onchange="mostrarImagen(event)">
                        <img id="vista-previa"
                            src="data:image/jpeg;base64,<?= base64_encode($registroActual['imagen'] ?? '') ?>"
                            alt="Imagen de Ejemplo" class="img-fluid" style="width:250px; height:250px;">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col d-flex justify-content-between">
                    <button type="submit" class="btn btn-outline-primary">ALTAS</button>
                    <button type="submit" class="btn btn-outline-danger" name="accion" value="BAJAS">BAJAS</button>
                    <button class="btn btn-outline-info">CONSULTAR</button>
                    <button type="submit" class="btn btn-outline-warning" name="accion"
                        value="MODIFICAR">MODIFICAR</button>
                </div>
            </div>

            <hr>
            <!-- BOTONES DE NAVEGACION -->
            <div class="row mb-3">
                <div class="col d-flex justify-content-between">
                    <button type="button" class="btn btn-primary" onclick="navegar('ADELANTE')">Adelante</button>
                    <button type="button" class="btn btn-secondary" onclick="navegar('ATRAS')">Atrás</button>
                    <button type="button" class="btn btn-success" onclick="navegar('INICIO')">Inicio</button>
                    <button type="button" class="btn btn-danger" onclick="navegar('FINAL')">Final</button>
                </div>
            </div>
            <hr>
        </form>
    </div>

    <div class="mt-auto d-flex justify-content-end p-3">
        <button class="btn btn-custom" onclick="window.history.back();">
            <img src="../iconos/flecha-izquierda.png" alt="Icono Regresar" class="me-2" style="width: 20px; height: 20px;">
            Regresar
        </button>
    </div>

    <!-- Incluir jQuery antes de cualquier script que lo utilice -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="../../js/consultas_caracteristica.js"></script>

    <script>
    function mostrarImagen(event) {
        const imagen = document.getElementById('vista-previa');
        imagen.src = URL.createObjectURL(event.target.files[0]);
        imagen.onload = function() {
            URL.revokeObjectURL(imagen.src);
        }
    }
    </script>
    <!-- Script para mostrar el mensaje usando Toastr -->
    <script>
    $(document).ready(function() {
        <?php if (!empty($message)): ?>
        toastr.success('<?php echo addslashes($message); ?>');
        <?php endif; ?>
    });
    </script>



</body>

</html>