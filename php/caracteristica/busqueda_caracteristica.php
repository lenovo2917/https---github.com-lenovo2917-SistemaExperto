<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/main.css">
    <title>Búsqueda por Síntomas</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <div class="container">
        <div class="row">
            <!-- Columna 1 -->
            <div class="col-12 col-md-8">
                <!-- Selección de Síntoma -->
                <div class="row mb-4">
                    <div class="col-12">
                        <label for="caracteristicaSelect" class="form-label">Seleccione un síntoma</label>
                        <select id="caracteristicaSelect" class="form-select form-select-lg">
                            <!-- Aquí se llenarán los síntomas desde la base de datos -->
                        </select>
                    </div>
                </div>

                <!-- Síntomas Seleccionados -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h3 class="text-center">Síntomas seleccionados</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="caracteristicasTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Síntoma</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aquí se agregarán los síntomas seleccionados -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna 2 -->
            <div class="col-12 col-md-4 text-center">
                <img id="caracteristicaImagen" src="" alt="Imagen del Síntoma" class="img-fluid rounded mb-4">

                <!-- Botones -->
                <div class="row">
                    <div class="col-12 mb-3">
                        <button id="quitarSintomaBtn" class="btn btn-danger w-100 btn-lg">Quitar Síntoma</button>
                    </div>
                    <div class="col-12 mb-3">
                        <button id="infereBtn" class="btn btn-warning w-100 btn-lg">Infere</button>
                    </div>
                    <div class="col-12 mb-3">
                        <button id="guardarBtn" class="btn btn-success w-100 btn-lg">Guardar</button>
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

    <!-- Toast container (centrado en la pantalla) -->
    <div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
        <!-- Toast -->
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="min-width: 500px; max-width: 800px;">
            <div class="toast-header">
                <strong class="me-auto">Resultados</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <!-- Aquí irá el mensaje del Toast -->
                El mensaje de resultado aparecerá aquí.
            </div>
            <div class="toast-footer">
                <button class="btn btn-primary" id="continuarBtn">Continuar infiriendo</button>
                <button class="btn btn-secondary" id="salirBtn">Salir</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        // Cargar síntomas desde la base de datos
        $.ajax({
            url: './consultar_caracteristica.php',
            type: 'POST',
            data: {
                tipoConsulta: 'general'
            },
            dataType: 'json',
            success: function(data) {
                data.forEach(function(caracteristica) {
                    $('#caracteristicaSelect').append(new Option(caracteristica.nombre, caracteristica.id));
                });
            }
        });

        // Agregar síntoma seleccionado a la tabla
        $('#caracteristicaSelect').change(function() {
            var caracteristicaId = $(this).val();
            var caracteristicaNombre = $("#caracteristicaSelect option:selected").text();

            // Verificar si el síntoma ya está en la tabla
            if ($('#caracteristicasTable tbody tr[data-id="' + caracteristicaId + '"]').length == 0) {
                $('#caracteristicasTable tbody').append('<tr data-id="' + caracteristicaId + '"><td>' +
                    caracteristicaNombre + '</td></tr>');
                // Mostrar imagen del síntoma
                $.ajax({
                    url: '../caracteristica/consultar_caracteristica.php',
                    type: 'POST',
                    data: {
                        tipoConsulta: 'individual',
                        id: caracteristicaId
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data && data.imagen) {
                            $('#caracteristicaImagen').attr('src', 'data:image/jpeg;base64,' + data.imagen);
                        }
                    }
                });

                // Actualizar la bandera de la característica seleccionada en raza_caracteristica
                $.ajax({
                    url: './actualizar_bandera.php',
                    type: 'POST',
                    data: {
                        id: caracteristicaId,
                        bandera: 1
                    }
                });
            } else {
                alert('El síntoma ya está seleccionado.');
            }
        });

        // Quitar síntoma seleccionado de la tabla
        $('#quitarSintomaBtn').click(function() {
            var selectedRow = $('#caracteristicasTable tbody tr.selected');
            var caracteristicaId = selectedRow.data('id');
            selectedRow.remove();
            $('#caracteristicaImagen').attr('src', '');

            // Actualizar la bandera de la característica quitada en raza_caracteristica
            $.ajax({
                url: './actualizar_bandera.php',
                type: 'POST',
                data: {
                    id: caracteristicaId,
                    bandera: 0
                }
            });
        });

        // Seleccionar fila de la tabla y mostrar imagen
        $('#caracteristicasTable').on('click', 'tbody tr', function() {
            $(this).toggleClass('selected').siblings().removeClass('selected');
            var caracteristicaId = $(this).data('id');
            // Mostrar imagen del síntoma seleccionado
            $.ajax({
                url: './consultar_caracteristica.php',
                type: 'POST',
                data: {
                    tipoConsulta: 'individual',
                    id: caracteristicaId
                },
                dataType: 'json',
                success: function(data) {
                    if (data && data.imagen) {
                        $('#caracteristicaImagen').attr('src', 'data:image/jpeg;base64,' + data.imagen);
                    }
                }
            });
        });

        $('#infereBtn').click(function() {
            $.post('./inferencia.php', function(response) {
                const data = JSON.parse(response);
                if (data.success) {
                    let resultados = data.resultados.map(r => {
                        let porcentaje = parseFloat(r.porcentaje);
                        return `La raza más probable es ${r.nombre} con un ${porcentaje.toFixed(2)}%`;
                    }).join('<br>');
                    showToast(resultados);
                } else {
                    showToast(data.message);
                }
            });
        });

        function showToast(message) {
            // Actualizar el contenido del toast
            var toastBody = $('.toast-body');
            toastBody.html(message);

            // Crear la instancia del toast de Bootstrap
            var toastElement = new bootstrap.Toast($('.toast')[0]);
            toastElement.show();
            
            // Acciones del botón "Salir"
            $('#salirBtn').click(function() {
                toastElement.hide();
                // Restablecer las banderas a 0 en raza_caracteristica
                $.ajax({
                    url: './actualizar_bandera.php',
                    type: 'POST',
                    data: {
                        reset: true
                    }
                });
            });

            // Acciones del botón "Continuar infiriendo"
            $('#continuarBtn').click(function() {
                toastElement.hide();
                // Agrega aquí más lógica si es necesario
            });
        }
    });
    </script>

</body>

</html>
