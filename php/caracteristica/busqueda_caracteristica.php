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

    <!-- Toast2 container (centrado en la pantalla) -->
    <div class="toast-container position-fixed top-50 start-50 translate-middle p-3" id="toast2Container" style="display: none;">
        <!-- Toast2 -->
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="min-width: 500px; max-width: 800px;">
            <div class="toast-body text-center">
                <button class="btn btn-success me-2" id="siBtn">Sí</button>
                <button class="btn btn-danger me-2" id="noBtn">No</button>
                <button class="btn btn-secondary" id="noseBtn">No sé</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        function actualizarImagen(caracteristicaId) {
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
        }

        function actualizarBandera(caracteristicaId, bandera) {
            $.ajax({
                url: './actualizar_bandera.php',
                type: 'POST',
                data: {
                    id: caracteristicaId,
                    bandera: bandera
                }
            });
        }

        function showToast(message) {
            var toastBody = $('.toast-body');
            toastBody.html(message);

            var toastElement = new bootstrap.Toast($('.toast')[0], {
                autohide: false
            });
            toastElement.show();
            
            $('.toast .btn-close').hide();

            $('#salirBtn').click(function() {
                toastElement.hide();
                $.ajax({
                    url: './actualizar_bandera.php',
                    type: 'POST',
                    data: {
                        reset: true
                    }
                });
            });

            $('#continuarBtn').click(function() {
                toastElement.hide();
                setTimeout(showToast2, 500);
            });
        }

        function showToast2() {
            $('#toast2Container .toast-body').html(`
                <button class="btn btn-success me-2" id="siBtn">Sí</button>
                <button class="btn btn-danger me-2" id="noBtn">No</button>
                <button class="btn btn-secondary" id="noseBtn">No sé</button>
            `);

            $('#toast2Container').show();

            var toast2Element = new bootstrap.Toast($('#toast2Container .toast')[0], {
                autohide: false
            });
            toast2Element.show();

            $('#siBtn, #noBtn, #noseBtn').click(function() {
                alert('Has seleccionado ' + $(this).text());
                toast2Element.hide();
                $('#toast2Container').hide();
            });
        }

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

        $('#caracteristicaSelect').change(function() {
            var caracteristicaId = $(this).val();
            var caracteristicaNombre = $("#caracteristicaSelect option:selected").text();

            if ($('#caracteristicasTable tbody tr[data-id="' + caracteristicaId + '"]').length == 0) {
                $('#caracteristicasTable tbody').append('<tr data-id="' + caracteristicaId + '"><td>' +
                    caracteristicaNombre + '</td></tr>');
                actualizarImagen(caracteristicaId);
                actualizarBandera(caracteristicaId, 1);
            } else {
                alert('El síntoma ya está seleccionado.');
            }
        });

        $('#quitarSintomaBtn').click(function() {
            var selectedRow = $('#caracteristicasTable tbody tr.selected');
            var caracteristicaId = selectedRow.data('id');
            selectedRow.remove();
            $('#caracteristicaImagen').attr('src', '');
            actualizarBandera(caracteristicaId, 0);
        });

        $('#caracteristicasTable').on('click', 'tbody tr', function() {
            $(this).toggleClass('selected').siblings().removeClass('selected');
            var caracteristicaId = $(this).data('id');
            actualizarImagen(caracteristicaId);
        });

        $('#infereBtn').click(function() {
            $.post('./inferencia.php', function(response) {
                const data = JSON.parse(response);
                if (data.success) {
                    let resultados = data.resultados.slice(0, 5).map(r => {
                        let porcentaje = parseFloat(r.porcentaje);
                        return `La raza más probable es ${r.nombre} con un ${porcentaje.toFixed(2)}%`;
                    }).join('<br>');
                    showToast(resultados);
                } else {
                    showToast(data.message);
                }
            });
        });
    });
    </script>

</body>

</html>