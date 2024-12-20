<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/main.css">
    <title>Búsqueda por caracteristicas</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <div class="container">
        <div class="row">
            <!-- Columna 1 -->
            <div class="col-12 col-md-8">
                <!-- Selección de Síntoma -->
                <div class="row mb-4">
                    <div class="col-12">
                        <label for="caracteristicaSelect" class="form-label">Seleccione una caracteristica</label>
                        <select id="caracteristicaSelect" class="form-select form-select-lg">
                            <!-- Aquí se llenarán los síntomas desde la base de datos -->
                        </select>
                    </div>
                </div>

                <!-- Síntomas Seleccionados -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h3 class="text-center"> caracteristicas seleccionadas</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="caracteristicasTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Caracteristicas</th>
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
                        <button id="quitarSintomaBtn" class="btn btn-danger w-100 btn-lg">Quitar Caracteristica</button>
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
            <img src="../../iconos/flecha-izquierda.png" alt="Icono Regresar" class="me-2"
                style="width: 20px; height: 20px;">
            Regresar
        </button>
    </div>

    <!-- Toast container (INFERENCIA 1) -->
    <div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
        <!-- Toast -->
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true"
            style="min-width: 500px; max-width: 800px;">
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

    <!-- Toast2 container (CONTINUANDO INFERENCIA) -->
    <div class="toast-container position-fixed top-50 start-50 translate-middle p-3" id="toast2Container"
        style="display: none;">
        <!-- Toast2 -->
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true"
            style="min-width: 500px; max-width: 800px;">
            <div class="toast-body text-center">
                <button class="btn btn-success me-2" id="siBtn">Sí</button>
                <button class="btn btn-danger me-2" id="noBtn">No</button>
            </div>
        </div>
    </div>

    <!-- MODULO DE EXPLICACION PARA SI -->

    <div id="toast3Container" class="toast-container position-fixed top-50 start-50 translate-middle p-3"
        style="display:none;">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Modulo de Explicacion</strong>
                
            </div>
            <div class=" modulo explicacion ">
                <!-- Contenido del toast3 -->

            </div>
            <button class="btn btn-secondary" id="salirBtn">Salir</button>
        </div>
    </div>
<!-- MODULO DE EXPLICACION PARA EL NO (toast4) -->
<div id="toast4Container" class="toast-container position-fixed top-50 start-50 translate-middle p-3" style="display:none;">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Modulo de Explicacion para el NO</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="modulo">
            <p>No es posible que sea esta raza: <span id="razaMayorProbabilidad"></span> porque se necesitan estas más características:</p>
            <ul id="caracteristicasFaltantes"></ul>
            <p>Razas con mayor probabilidad:</p>
            <ol id="razasActualizadas"></ol>
            <button class="btn btn-secondary" id="salirToast4Btn">Salir</button>
        </div>
    </div>
</div>






    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        $('#caracteristicaImagen').attr('src', 'data:image/jpeg;base64,' + data
                            .imagen);
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

            // Botones de acción en el mensaje final
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

            $('#continuarBtn').off('click').on('click', function() {
                toastElement.hide();
                // Solo continúa mostrando Toast3 si no es un mensaje final
                if (!message.includes("la raza es")) {
                    showToast3();
                }
            });
        }


        function showToast3() {
            $.post('./inferencia.php', function(response) {
                const data = JSON.parse(response);

                if (data.success) {
                    const razaMayorProb = data.resultados[0];
                    const razaId = razaMayorProb.id;

                    $.ajax({
                        url: './consultar_caracteristicas_faltantes.php',
                        type: 'POST',
                        data: {
                            razaId: razaId
                        },
                        dataType: 'json',
                        success: function(faltantes) {
                            if (faltantes.length > 0) {
                                let currentIndex = 0;

                                function showNextCaracteristica() {
                                    if (currentIndex < faltantes.length) {
                                        const caracteristica = faltantes[currentIndex];
                                        const mensaje =
                                            `Tu raza tiene: ${caracteristica.nombre}?`;
                                        $('#toast2Container .toast-body').html(`
                                            <p>${mensaje}</p>
                                            <button class="btn btn-success me-2" id="siBtn">Sí</button>
                                            <button class="btn btn-danger me-2" id="noBtn">No</button>
                                        `);

                                        $('#toast2Container').show();

                                        var toast2Element = new bootstrap.Toast($(
                                            '#toast2Container .toast')[0], {
                                            autohide: false
                                        });
                                        toast2Element.show();

                                        $('#siBtn').off('click').on('click', function() {
                                            $.post('./actualizar_pesos.php', {
                                                caracteristicaId: caracteristica.id,
                                                razaId: razaId,
                                                bandera: 1
                                            }, function(response) {
                                                currentIndex++;
                                                showNextCaracteristica();
                                            });
                                        });

                                        $('#noBtn').off('click').on('click', function() {
                                            $.post('./actualizar_pesos.php', {
                                                caracteristicaId: caracteristica.id,
                                                razaId: razaId,
                                                bandera: 0
                                            }, function(response) {
                                                toast2Element.hide();
                                                $('#toast2Container').hide();
                                                showToast4(razaId, razaMayorProb.nombre, faltantes);
                                            });
                                        });

                                    } else {
                                        // Cuando no hay más características por verificar
                                        $('#toast2Container').hide();
                                        const mensajeFinal =
                                            `Basado en las características seleccionadas, la raza es ${razaMayorProb.nombre}.`;
                                        showToast(mensajeFinal);
                                    }
                                }

                                showNextCaracteristica();
                            } else {
                                // Si no hay características faltantes, mostrar el resultado final
                                const mensajeFinal = `Basado en las características seleccionadas, la raza es ${razaMayorProb.nombre}.`;
                                showToast(mensajeFinal);
                            }
                        }
                    });
                } else {
                    alert(data.message);
                }
            });
        }

        function showToast4(razaId, razaNombre, faltantes) {
            $.post('./inferencia.php', function(response) {
                const data = JSON.parse(response);

                if (data.success) {
                    $.ajax({
                        url: './actualizar_bandera.php',
                        type: 'POST',
                        data: {
                            razaId: razaId,
                            bandera: 1
                        },
                        success: function() {
                            // Inferir nuevamente para obtener nuevos datos
                            $.post('./inferencia.php', function(newResponse) {
                                const newData = JSON.parse(newResponse);
                                if (newData.success) {
                                    let razaMayorProb = newData.resultados[0];
                                    let razaMayorProbName = razaMayorProb.nombre;
                                    let razaMayorProbPorcentaje = parseFloat(razaMayorProb.porcentaje).toFixed(2);
                                    $('#razaMayorProbabilidad').text(`${razaNombre}`);

                                    // Consultar características faltantes actualizadas
                                    $.ajax({
                                        url: './consultar_caracteristicas_faltantes.php',
                                        type: 'POST',
                                        data: {
                                            razaId: razaMayorProb.id
                                        },
                                        dataType: 'json',
                                        success: function(faltantesActualizadas) {
                                            let caracteristicasList = '';
                                            faltantesActualizadas.forEach(function(caracteristica) {
                                                caracteristicasList += `<li>${caracteristica.nombre}</li>`;
                                            });
                                            $('#caracteristicasFaltantes').html(caracteristicasList);

                                            let razasActualizadasList = '';
                                            newData.resultados.slice(1, 6).forEach(function(resultado) { 
                                                let porcentaje = parseFloat(resultado.porcentaje).toFixed(2);
                                                let caracteristicas = resultado.caracteristicas.split(', ').map(c => `<li>${c}</li>`).join('');
                                                razasActualizadasList += `<li>${resultado.nombre}: ${porcentaje}%<ul>${caracteristicas}</ul></li>`;
                                            });
                                            $('#razasActualizadas').html(razasActualizadasList);

                                            // Mostrar el toast4 con los nuevos datos
                                            var toast4Element = new bootstrap.Toast($('#toast4Container .toast')[0]);
                                            $('#toast4Container').show();
                                            toast4Element.show();
                                        }
                                    });
                                } else {
                                    showToast(newData.message);
                                }
                            });
                        }
                    });
                }
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
                    $('#caracteristicaSelect').append(new Option(caracteristica.nombre,
                        caracteristica.id));
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

<script>
$(document).ready(function() {
    $('#salirToast4Btn').click(function() {
        var toast4Element = new bootstrap.Toast($('#toast4Container .toast')[0]);
        toast4Element.hide();
    });

    function showToast4(razaId, razaNombre, faltantes) {
        $.post('./inferencia.php', function(response) {
            const data = JSON.parse(response);

            if (data.success) {
                $.ajax({
                    url: './actualizar_bandera.php',
                    type: 'POST',
                    data: {
                        razaId: razaId,
                        bandera: 1
                    },
                    success: function() {
                        // Inferir nuevamente para obtener nuevos datos
                        $.post('./inferencia.php', function(newResponse) {
                            const newData = JSON.parse(newResponse);
                            if (newData.success) {
                                let razaMayorProb = newData.resultados[0];
                                let razaMayorProbName = razaMayorProb.nombre;
                                let razaMayorProbPorcentaje = parseFloat(razaMayorProb.porcentaje).toFixed(2);
                                $('#razaMayorProbabilidad').text(`${razaNombre}`);

                                // Consultar características faltantes actualizadas
                                $.ajax({
                                    url: './consultar_caracteristicas_faltantes.php',
                                    type: 'POST',
                                    data: {
                                        razaId: razaMayorProb.id
                                    },
                                    dataType: 'json',
                                    success: function(faltantesActualizadas) {
                                        let caracteristicasList = '';
                                        faltantesActualizadas.forEach(function(caracteristica) {
                                            caracteristicasList += `<li>${caracteristica.nombre}</li>`;
                                        });
                                        $('#caracteristicasFaltantes').html(caracteristicasList);

                                        let razasActualizadasList = '';
                                        newData.resultados.slice(1, 5).forEach(function(resultado) { 
                                            let porcentaje = parseFloat(resultado.porcentaje).toFixed(2);
                                            let caracteristicas = resultado.caracteristicas.split(', ').map(c => `<li>${c}</li>`).join('');
                                            razasActualizadasList += `<li>${resultado.nombre}: ${porcentaje}%<ul>${caracteristicas}</ul></li>`;
                                        });
                                        $('#razasActualizadas').html(razasActualizadasList);

                                        // Mostrar el toast4 con los nuevos datos
                                        var toast4Element = new bootstrap.Toast($('#toast4Container .toast')[0]);
                                        $('#toast4Container').show();
                                        toast4Element.show();
                                    }
                                });
                            } else {
                                showToast(newData.message);
                            }
                        });
                    }
                });
            }
        });
    }
});
</script>

</body>

</html>