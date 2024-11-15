// Función para la consulta general
function consultaGeneral() {
    $.ajax({
        url: '../../php/controllers/consultar.php',
        method: 'POST',
        data: { tipoConsulta: 'general' },
        dataType: 'json',
        success: function (data) {
            let tabla = '<table class="table table-bordered"><thead><tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Imagen</th></tr></thead><tbody>';
            data.forEach(item => {
                tabla += `<tr>
                    <td>${item.id}</td>
                    <td>${item.nombre}</td>
                    <td>${item.descripcion}</td>
                    <td><img src="data:image/jpeg;base64,${item.imagen}" alt="Imagen" width="100"></td>
                </tr>`;
            });
            tabla += '</tbody></table>';
            $('#contenidoModal').html(tabla);
            $('#consultaModal').modal('show');
        },
        error: function () {
            alert('Error al realizar la consulta general.');
        }
    });
}

// Función para la consulta individual
function preguntarID() {
    const id = prompt('Por favor ingrese el ID que desea consultar:');
    if (id) {
        $.ajax({
            url: '../../php/controllers/consultar.php',
            method: 'POST',
            data: { tipoConsulta: 'individual', id: id },
            dataType: 'json',
            success: function (data) {
                if (data) {
                    let resultado = `<p><strong>ID:</strong> ${data.id}</p>
                                     <p><strong>Nombre:</strong> ${data.nombre}</p>
                                     <p><strong>Descripción:</strong> ${data.descripcion}</p>
                                     <img src="data:image/jpeg;base64,${data.imagen}" alt="Imagen" class="img-fluid">`;
                    $('#contenidoModal').html(resultado);
                    $('#consultaModal').modal('show');
                } else {
                    alert('No se encontró un registro con ese ID.');
                }
            },
            error: function () {
                alert('Error al realizar la consulta individual.');
            }
        });
    }
}

// Asociar la función mostrarToast() al botón de consulta
$(document).on('click', '.btn-outline-info', function (e) {
    e.preventDefault();
    mostrarToast();

});

  // Función para mostrar el Toast
  $(document).ready(function () {
    $('#opcionConsultaToast').toast({ autohide: false });
});

// Función que se activa al hacer clic en el botón "CONSULTAR"
function mostrarToast() {
    $('#opcionConsultaToast').toast('show');
}
