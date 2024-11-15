<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="fotos/icono.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&family=Montagu+Slab:opsz,wght@16..144,100..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/menu.css">
    <title>Menú General</title>
</head>

<body class="background-image">
    <div class="container mt-4">
        <h2 class="text-center page-title">Menú General</h2>

        <div class="text-center">
            <button class="btn btn-custom m-2" data-bs-toggle="modal" data-bs-target="#modalActual">Yo
                actualmente</button>
            <button class="btn btn-custom m-2" data-bs-toggle="modal" data-bs-target="#modalHobbys">Mis hobbys</button>
            <button class="btn btn-custom m-2" data-bs-toggle="modal" data-bs-target="#modalFuturo">Yo en el
                futuro</button>
        </div>
        <div class="text-center">
            <a href="php/front_end/main.php" class="btn btn-custom mt-3">Regresar</a>
        </div>
    </div>

    <div class="modal fade" id="modalActual" tabindex="-1" aria-labelledby="modalActualLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalActualLabel">Yo actualmente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-wrap justify-content-center">
                        <?php
                        $actualImages = [
                            ["src" => "fotos/estudiante.png", "text" => "Siendo estudiante en Ingeniería en sistemas."],
                            ["src" => "fotos/estudiando.jpeg", "text" => "Estudiando inglés."],
                            ["src" => "fotos/estresada.jpeg", "text" => "Un poco estresada por mi residencia."],
                            ["src" => "fotos/servicio.png", "text" => "Mi finalización de mi servicio social."],
                            ["src" => "fotos/tejer.png", "text" => "Estoy tejiendo mi stock de crochet para vender."]
                        ];

                        foreach ($actualImages as $image) {
                            echo '<div class="card m-2" style="width: 14rem;">
                                    <img src="' . $image['src'] . '" class="card-img-top" alt="Imagen">
                                    <div class="card-body">
                                        <p class="card-text">' . $image['text'] . '</p>
                                    </div>
                                  </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHobbys" tabindex="-1" aria-labelledby="modalHobbysLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHobbysLabel">Mis hobbys</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-wrap justify-content-center">
                        <?php
                        $hobbiesImages = [
                            ["src" => "fotos/h_leer.png", "text" => "Leer"],
                            ["src" => "fotos/h_perro.png", "text" => "Jugar con mi perrito Tommen"],
                            ["src" => "fotos/h_musica.jpeg", "text" => "Escuchar música"],
                            ["src" => "fotos/h_manualidades.png", "text" => "Crear manualidades."],
                            ["src" => "fotos/h_tejer.png", "text" => "Tejer."]
                        ];

                        foreach ($hobbiesImages as $hobby) {
                            echo '<div class="card m-2" style="width: 14rem;">
                                    <img src="' . $hobby['src'] . '" class="card-img-top" alt="Imagen">
                                    <div class="card-body">
                                        <p class="card-text">' . $hobby['text'] . '</p>
                                    </div>
                                  </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalFuturo" tabindex="-1" aria-labelledby="modalFuturoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFuturoLabel">Yo en el futuro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-wrap justify-content-center">
                        <?php
                        $futureImages = [
                            ["src" => "fotos/f_trabajo.png", "text" => "Trabajando como gestora de proyectos"],
                            ["src" => "fotos/f_hobbie.png", "text" => "Tener mi espacio de reparaciones"],
                            ["src" => "fotos/f_sola.png", "text" => "Viviendo sola con mi perrito"],
                            ["src" => "fotos/f_graduada.png", "text" => "Graduada"],
                            ["src" => "fotos/f_alber.png", "text" => "Teniendo un santuario para animales."]
                        ];

                        foreach ($futureImages as $future) {
                            echo '<div class="card m-2" style="width: 14rem;">
                                    <img src="' . $future['src'] . '" class="card-img-top" alt="Imagen">
                                    <div class="card-body">
                                        <p class="card-text">' . $future['text'] . '</p>
                                    </div>
                                  </div>';
                        }
                        ?>
                    </div>
                </div>
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

    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
