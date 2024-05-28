document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('Fecha').addEventListener('change', function() {
        var fechaSeleccionada = this.value;

        // Crear el objeto FormData para enviar los datos al servidor
        var formData = new FormData();
        formData.append('fecha', fechaSeleccionada);

        fetch('../Configuracion/ValidarFecha.php', {
            method: 'POST',
            body: formData
        })
     .then(response => response.json())
     .then(data => {
            console.log(data); 
            if (data.mensaje === 'Fecha no laborable') {
                toastr.error('Fecha no laborable');

                this.value = '';
            } else if (data.mensaje === 'Fecha recibida') {
                //alert("La fecha recibida");
            } else if (data.error) {
                alert(data.error); 
            }
        })
     .catch(error => {
            console.error('Error:', error);
            toastr.error('Hubo un error al enviar la fecha');

        });
    });

});