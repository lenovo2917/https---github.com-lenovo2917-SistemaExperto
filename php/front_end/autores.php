<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../fotos/icono.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&family=Montagu+Slab:opsz,wght@16..144,100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/main.css"> 
</head>
<body style="background-color: #FBF9F1;">
    <div class="container mt-4">
        <h2 class="text-center" style="font-family: 'Montagu Slab', serif; color: #eece98;">AUTORES DEL SISTEMA</h2>
        <br><br>
        
        <!-- Cuadrícula de 2x2 -->
        <div class="row">
            <!-- Primera fila -->
            <div class="col-md-6 d-flex justify-content-center">
                <img src="../../fotos/me.jpg" class="img-thumbnail" alt="Imagen 1" style="width: 200px; height:300px;">
            </div>
            <div class="col-md-6">
                <h2 style="font-family: 'Amatic SC', cursive; color: #064d58;">Datos Personales</h2>
                <p style="font-family: 'Amatic SC', cursive; color: #064d58; font-size: 24px;">
                    Nombre: Alondra Myriel Gutierrez Villegas<br>
                    Dirección: Tlatenchi, Morelos
                    <br>Teléfono: 7341479920<br>
                    E-mail: myrgv6@gmail.com</p>
            </div>

            <!-- Segunda fila -->
            <div class="col-md-6 d-flex justify-content-center mt-4">
                <img src="../../fotos/pichichu.jpg" class="img-thumbnail" alt="Imagen 2" style="width: 200px; height: 300px;">
            </div>
            <div class="col-md-6 mt-4">
                <h2 style="font-family: 'Amatic SC', cursive; color: #064d58;">Datos extras</h2>
                <p style="font-family: 'Amatic SC', cursive; color: #064d58; font-size: 24px;">
                    Nombre: José Guadalupe Zendejas Sotelo<br>
                    Dirección: Iguala, Guerrero<br>
                    Teléfono: 7331550172<br>
                    E-mail: josenator6@gmail.com</p>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
