function navegar(direccion) {
    const idActual = $('#nombre').data('id'); // Usa el data-id directamente
    $.ajax({
        url: '/Nueva%20carpeta/PRACTICAia/php/caracteristica/navegar_caracteristica.php',
        method: 'POST',
        data: { id: idActual, direccion: direccion },
        dataType: 'json',
        success: function (data) {
            if (data) {
                $('#nombre').val(data.nombre).data('id', data.id); // Actualiza el data-id
                $('#vista-previa').attr('src', 'data:image/jpeg;base64,' + data.imagen);
                $('input[name="id"]').val(data.id); // Actualiza el campo oculto del ID
            } else {
                alert('No hay más registros en esta dirección.');
            }
        },
        error: function () {
            alert('Error al navegar.');
        }
    });
}