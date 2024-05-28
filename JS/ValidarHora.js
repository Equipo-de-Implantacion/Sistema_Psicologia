document.addEventListener('DOMContentLoaded', function () {
    const fechaInput = document.getElementById('Fecha');
    const horaInput = document.getElementById('Hora');

    // Función para enviar los datos
    function enviarDatos() {
        var fechaSeleccionada = fechaInput.value;
        var horaSeleccionada = horaInput.value;

        // Crear el objeto FormData para enviar los datos al servidor
        var formData = new FormData();
        formData.append('fecha', fechaSeleccionada);
        formData.append('hora', horaSeleccionada);

        fetch('../Configuracion/ValidarHora.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json()) // Cambiado a parsear como JSON
            .then(data => {
                console.log("Respuesta del servidor:", data);
                if (data.estado === 'ocupada') {
                    toastr.error('La hora seleccionada está ocupada');

                    this.value = '';
                } else if (data.estado === 'disponible') {
                    // alert("La hora seleccionada está disponible.");
                } else {
                    //alert("No se encontraron registros para la fecha seleccionada.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('Hubo un error al enviar la fecha');

            });
    }

    // Escucha el evento change en los inputs para enviar los datos
    fechaInput.addEventListener('change', enviarDatos);
    horaInput.addEventListener('change', enviarDatos);
});
