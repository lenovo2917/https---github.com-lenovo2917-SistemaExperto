<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&family=Montagu+Slab:wght@100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <title>Login de Usuarios</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Aquí puedes agregar tu contenido -->
    <div class="container d-flex flex-column justify-content-center align-items-center flex-grow-1">
        <!-- INICIO DEL CONTENIDO -->

        <div class="row justify-content-center w-100">
            <div class="col-12 col-md-8 mb-3">
                <a href="../caracteristica//busqueda_caracteristica.php" class="btn btn-primary btn-lg btn-block" style="width: 100%;">BUSQUEDA POR SINTOMAS (búsqueda hacia adelante)</a>
            </div>
            <div class="col-12 col-md-8">
                <a href="php/busqueda_razaes.php" class="btn btn-secondary btn-lg btn-block" style="width: 100%;">BUSQUEDA POR ENFERMEDADES (búsqueda hacia atrás)</a>
            </div>
        </div>

        <!-- FIN DEL CONTENIDO -->
    </div>

    <!-- Botón Regresar en la parte inferior derecha -->
    <div class="mt-auto d-flex justify-content-end p-3">
        <button class="btn btn-custom" onclick="window.history.back();">
            <img src="iconos/flecha-izquierda.png" alt="Icono Regresar" class="me-2" style="width: 20px; height: 20px;">
            Regresar
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
