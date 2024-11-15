<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/fotos/icono.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&family=Montagu+Slab:opsz,wght@16..144,100..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="main.css">
    <title><?php echo "Pantalla de Bienvenida"; ?></title>
</head>

<body>

    <div class="container-fluid p-0">
        <img src="../../fotos/ENCABEZADO.jpg" class="img-fluid w-100" alt="Banner">
    </div>

    <div class="text-center my-4">
        <h1 class="page-title"><?php echo "Bienvenidos"; ?></h1>
        <h3 class="page-subtitle"><?php echo "Instituto Tecnologico de Zacatepec"; ?></h3>
        <p class="page-author" style="font-size: 30px;"><?php echo "SISTEMA EXPERTO GENERICO"; ?></p>
    </div>

    <div class="d-flex justify-content-between position-fixed bottom-0 w-100 px-4 mb-4">
        <a href="javascript:void(0);" class="btn btn-custom" onclick="cerrarPestana()">
            <img src="../../iconos/cerrar-sesion.png" alt="Icono de Salir"
                style="width: 20px; height: 20px; margin-right: 5px;">
            Salir
        </a>

        <div class="d-flex">
            <a href="acerca.php" class="btn btn-custom me-2">
                <img src="../../iconos/acerca-de.png" alt="Icono Acerca de"
                    style="width: 20px; height: 20px; margin-right: 5px;">
                Acerca del sistema
            </a>
            <a href="interfaces.php" class="btn btn-custom">
                <img src="../../iconos/entrar.png" alt="Icono Entrar"
                    style="width: 20px; height: 20px; margin-right: 5px;">
                Entrar
            </a>
        </div>
    </div>

 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>