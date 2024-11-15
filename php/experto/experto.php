<!-- views/header.php -->
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&family=Montagu+Slab:wght@100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
    <title>Datos Objeto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="../../css/main.css">
</head>

<body>
    <div class="container mt-4">
        <h1 class="text-center">MENU EXPERTO</h1>
        <div class="row justify-content-center align-items-center">
            <div class="col-md-2 d-flex flex-column align-items-end">
                <img src="../../iconos/agregar.png" alt="Agregar Objeto" class="mb-3" style="height: 50px; width: 50px;">
                <img src="../../iconos/caracteristica.png" alt="Agregar Características" class="mb-3" style="height: 50px; width: 50px;">
                <img src="../../iconos/relacion.png" alt="Cuadro-Relación" class="mb-3" style="height: 50px; width: 50px;">
            </div>
            <div class="col-md-10 d-flex flex-column">
                <button class="btn btn-custom mb-3 w-100 text-start" style="height: 50px;" 
                        onclick="window.location.href='./agregar_objeto.php'">Agregar Objeto</button>
                <button class="btn btn-custom mb-3 w-100 text-start" style="height: 50px;" 
                        onclick="window.location.href='../../php/caracteristica/agregar_caracteristicas.php'">Agregar Características</button>
                <button class="btn btn-custom mb-3 w-100 text-start" style="height: 50px;" 
                        onclick="window.location.href='../../Cuadro_relacion/Cuadro_Relacion.php'">Cuadro-Relación</button>
            </div>
        </div>
    </div>
    <!-- Botón Regresar -->
    <div class="mt-auto d-flex justify-content-end p-3">
        <button class="btn btn-custom" onclick="window.history.back();">
            <img src="../../iconos/flecha-izquierda.png" alt="Icono Regresar" class="me-2" style="width: 20px; height: 20px;">
            Regresar
        </button>
    </div>
    <!-- views/footer.php -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>
</html>
