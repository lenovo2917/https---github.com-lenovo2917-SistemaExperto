<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&family=Montagu+Slab:wght@100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/main.css">
    <title>Login de Usuarios</title>
</head>
<body class="d-flex flex-column min-vh-100">
<div class="container mt-4">
        <h1 class="text-center mb-4">Inicio de Sesión</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h2>Selecciona tu tipo de usuario:</h2>
                        <div class="d-grid gap-2 mt-4">
                            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#expertoModal">
                                <img src="../../iconos/experto.png" alt="Icono Experto" class="me-2 icono-usuario">
                                Experto
                            </button>
                            <a href="./usuario.php" class="btn btn-dark">
                                <img src="../../iconos/usuario.png" alt="Icono Usuario" class="me-2 icono-usuario">
                                Usuario
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Experto -->
    <div class="modal fade" id="expertoModal" tabindex="-1" aria-labelledby="expertoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="expertoModalLabel">Inicio de Sesión - Experto</h3>
                    <button type="button" class="btn-close"z data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginExpertoForm">
                        <input type="hidden" name="tipo_usuario" value="experto">
                        <div class="mb-3">
                            <label for="contrasenaE" class="form-label">Contraseña</label>
                            <div class="input-group has-validation">
                                <input type="password" class="form-control" id="contrasenaE" name="contrasenaE" required>
                                <div class="invalid-feedback" id="errorMensajeE">
                                    <!-- Aquí se mostrará el mensaje de error -->
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                    </form>
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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            // AJAX para el formulario de experto
            $('#loginExpertoForm').on('submit', function(e){
                e.preventDefault(); // Evita que el formulario se envíe por la vía tradicional
                let contrasenaE = $('#contrasenaE').val();
                
                $.ajax({
                    url: '../controllers/procesar_login.php',
                    type: 'POST',
                    data: { tipo_usuario: 'experto', contrasenaE: contrasenaE },
                    dataType: 'json',
                    success: function(response){
                        if(response.success){
                            window.location.href = '../experto/experto.php';
                        } else {
                            $('#contrasenaE').addClass('is-invalid');
                            $('#errorMensajeE').text('Contraseña incorrecta. Inténtalo de nuevo.');
                        }
                    }
                });
            });

            // AJAX para el formulario de usuario (similar al de experto)
            $('#loginUsuarioForm').on('submit', function(e){
                e.preventDefault();
                let contrasenaU = $('#contrasenaU').val();
                
                $.ajax({
                    url: '../controllers/procesar_login.php',
                    type: 'POST',
                    data: { tipo_usuario: 'usuario', contrasenaU: contrasenaU },
                    dataType: 'json',
                    success: function(response){
                        if(response.success){
                            window.location.href = '../front_end/usuario.php';
                        } else {
                            $('#contrasenaU').addClass('is-invalid');
                            $('#errorMensajeU').text('Contraseña incorrecta. Inténtalo de nuevo.');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
