<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&family=Montagu+Slab:wght@100..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css">
    <title>Cuadro Relación</title>
    <style>
    .table-hover tbody tr:hover {
        background-color: #f2f2f2;
    }

    .table tbody tr.selected {
        background-color: #6c757d;
        color: white;
    }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">


    <div class="container mt-4">
        <h1 class="text-center mb-4">Cuadro Relación</h1>

    
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="raza" class="form-label">Enfermedad:</label>
                <select id="raza" class="form-select">
                    <option value="">Selecciona una raza</option>
                    <!-- Opciones se llenarán dinámicamente -->
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="caracteristica" class="form-label">Síntoma:</label>
                <select id="caracteristica" class="form-select">
                    <option value="">Selecciona un síntoma</option>
                    <!-- Opciones se llenarán dinámicamente -->
                </select>
            </div>

            <div class="col-md-3">
                <label for="peso" class="form-label">Peso (%)</label>
                <input type="number" id="peso" class="form-control" min="0" max="100" step="1" value="0">
            </div>

            <div class="col-md-3 d-flex align-items-center">
                <img src="https://via.placeholder.com/320x200" alt="Imagen por Default" class="img-fluid"
                    style="max-height: 200px;">
            </div>
        </div>

        <h3>Síntomas Seleccionados</h3>
        <div class="row">
            <div class="col-md-9">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Síntoma</th>
                            <th>Peso (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se agregarán los síntomas seleccionados -->
                    </tbody>
                </table>
            </div>

            <div class="col-md-3 d-flex flex-column justify-content-start">
                <button id="agregar" class="btn btn-primary mb-2">Añadir</button>
                <button class="btn btn-danger">Borrar</button>
            </div>
        </div>

        <div class="row mt-4 justify-content-center">
            <div class="col-md-3">
                <button id="guardar" class="btn btn-success w-100">Guardar</button>
            </div>
            <div class="col-md-3">
                <button class="btn btn-secondary w-100">Cancelar</button>
            </div>
        </div>
    </div>

    <!-- Tostada de Bootstrap -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toast-success" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Éxito</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Datos guardados exitosamente.
            </div>
        </div>
    </div>

    <!-- Botón Regresar -->
    <div class="mt-auto d-flex justify-content-end p-3">
        <button class="btn btn-custom" onclick="window.history.back();">
            <img src="../iconos/flecha-izquierda.png" alt="Icono Regresar" class="me-2" style="width: 20px; height: 20px;">
            Regresar
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    // Obtener referencias a los elementos del DOM
    const guardarBtn = document.getElementById('guardar');
    const razaSelect = document.getElementById('raza');
    const caracteristicaSelect = document.getElementById('caracteristica');
    const pesoInput = document.getElementById('peso');
    const tbody = document.querySelector('table tbody');
    const alertSuccess = document.getElementById('alert-success');

    // Arrays para almacenar las características y pesos seleccionados
    let caracteristicasSeleccionados = [];
    let pesosSeleccionados = [];
    let caracteristicasExistentes = [];

    // Obtener razaes y síntomas
    fetch('./get_data.php')
        .then(response => response.json())
        .then(data => {
            // Llenar el desplegable de razaes
            data.razaes.forEach(raza => {
                const option = document.createElement('option');
                option.value = raza.id;
                option.setAttribute('data-imagen', raza.imagen); // Guardar la imagen en un atributo
                option.textContent = raza.nombre;
                razaSelect.appendChild(option);
            });

            // Llenar el desplegable de síntomas
            data.caracteristicas.forEach(caracteristica => {
                const option = document.createElement('option');
                option.value = caracteristica.id;
                option.textContent = caracteristica.nombre;
                caracteristicaSelect.appendChild(option);
            });
        });

    // Cambiar la imagen al seleccionar una raza y obtener las características existentes
    razaSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const imagenUrl = selectedOption.getAttribute('data-imagen');
        const razaId = this.value;

        const imagenElemento = document.querySelector('.img-fluid');
        imagenElemento.src = imagenUrl ? imagenUrl : 'https://via.placeholder.com/320x200';

        if (razaId) {
            fetch(`./get_relaciones.php?raza_id=${razaId}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('table tbody');
                    tbody.innerHTML = ''; // Limpiar la tabla antes de llenarla
                    caracteristicasExistentes = data.map(raza_caracteristica => raza_caracteristica.caracteristica_id);
                    data.forEach(raza_caracteristica => {
                        const newRow = document.createElement('tr');
                        newRow.dataset.raza_caracteristicaId = raza_caracteristica.id;
                        newRow.innerHTML = `<td>${raza_caracteristica.caracteristica}</td><td>${raza_caracteristica.peso}%</td>`;
                        tbody.appendChild(newRow);
                    });
                })
                .catch(error => {
                    console.error('Error al cargar raza_caracteristicaes:', error);
                });
        }
    });

    // Añadir un síntoma
    document.getElementById('agregar').addEventListener('click', () => {
        const caracteristicaId = caracteristicaSelect.value;
        const caracteristicaNombre = caracteristicaSelect.options[caracteristicaSelect.selectedIndex].text;
        const peso = pesoInput.value;

        if (caracteristicaId && peso) {
            if (caracteristicasSeleccionados.includes(caracteristicaId) || caracteristicasExistentes.includes(parseInt(caracteristicaId))) {
                alert('La característica ya ha sido agregada.');
                return;
            }

            caracteristicasSeleccionados.push(caracteristicaId);
            pesosSeleccionados.push(peso);

            const newRow = document.createElement('tr');
            newRow.innerHTML = `<td>${caracteristicaNombre}</td><td>${peso}%</td>`;
            tbody.appendChild(newRow);
        }
    });

    // Borrar un síntoma
    document.querySelector('.btn-danger').addEventListener('click', () => {
        const selectedRow = document.querySelector('table tbody tr.selected');
        if (selectedRow) {
            const raza_caracteristicaId = selectedRow.dataset.raza_caracteristicaId; // Obtener el ID de la relación desde el atributo
            console.log("ID de relación para eliminar:", raza_caracteristicaId);

            // Hacer una llamada para eliminar el registro en la base de datos
            fetch('./delete_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    id: raza_caracteristicaId // Envía el ID de la relación
                })
            }).then(response => {
                if (response.ok) {
                    selectedRow.remove();
                } else {
                    console.error("Error al eliminar el síntoma:", response.statusText);
                }
            }).catch(error => {
                console.error('Error al eliminar el síntoma:', error);
            });
        } else {
            alert('Por favor, selecciona un síntoma para eliminar.');
        }
    });

    // Seleccionar una fila al hacer clic
    document.querySelector('table tbody').addEventListener('click', (event) => {
        const row = event.target.closest('tr');
        if (row) {
            // Des-seleccionar cualquier otra fila seleccionada
            const selectedRows = document.querySelectorAll('table tbody tr.selected');
            selectedRows.forEach(selectedRow => {
                selectedRow.classList.remove('selected');
            });

            // Seleccionar la fila actual
            row.classList.add('selected');
        }
    });

    // Guardar datos
    guardarBtn.addEventListener('click', () => {
        const razaId = razaSelect.value;

        if (razaId && caracteristicasSeleccionados.length > 0 && pesosSeleccionados.length > 0) {
            fetch('./save_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    raza_id: razaId,
                    caracteristicas: caracteristicasSeleccionados,
                    pesos: pesosSeleccionados
                })
            }).then(response => response.json())
              .then(data => {
                  if (data.status === 'success') {
                      // Mostrar la tostada de éxito
                      const toastEl = document.getElementById('toast-success');
                      const toast = new bootstrap.Toast(toastEl);
                      toast.show();

                      // Recargar la página después de un breve retraso
                      setTimeout(() => {
                          location.reload();
                      }, 3000); // Esperar 2 segundos antes de recargar
                  } else {
                      alert('Error al guardar las relaciones: ' + data.message);
                  }
              }).catch(error => {
                  console.error('Error al guardar las relaciones:', error);
              });
        } else {
            alert('Por favor, selecciona una raza y agrega al menos una característica con su peso.');
        }
    });

    // Cancelar acción
    document.querySelector('.btn-secondary').addEventListener('click', () => {
        // Limpiar la tabla y los arrays
        tbody.innerHTML = '';
        caracteristicasSeleccionados = [];
        pesosSeleccionados = [];

        // Resetear los valores de los inputs
        razaSelect.selectedIndex = 0;
        caracteristicaSelect.selectedIndex = 0;
        pesoInput.value = 0;

        alert("Se ha cancelado la acción y limpiado la selección.");
    });
    </script>

</body>

</html>