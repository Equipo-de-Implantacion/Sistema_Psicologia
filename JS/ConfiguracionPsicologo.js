const fechasSeleccionadas = new Set();

function agregarFecha() {

    
    const nuevoInput = document.createElement("input");
    nuevoInput.type = "date";
    nuevoInput.name = "nuevaFecha[]";
    nuevoInput.className = "form-select"; // Agregar la clase form-select de Bootstrap

    // Obtener la fecha actual y formatearla como yyyy-mm-dd
    const hoy = new Date();
    const dia = String(hoy.getDate()).padStart(2, '0');
    const mes = String(hoy.getMonth() + 1).padStart(2, '0');
    const ano = hoy.getFullYear();
    nuevoInput.min = `${ano}-${mes}-${dia}`;

    // Evento para manejar cuando el usuario selecciona una fecha
    nuevoInput.addEventListener('change', () => {
        if (!fechasSeleccionadas.has(nuevoInput.value)) {
            fechasSeleccionadas.add(nuevoInput.value);
            toastr.success("Fecha agregada exitosamente.");
        } else {
            nuevoInput.value = ''; // Limpiar el input si es duplicado
            toastr.error("Esta fecha ya ha sido seleccionada.");
        }
    });

    // Agregar el nuevo input al contenedor
    const contenedor = document.getElementById('contenedorFechas');
    contenedor.appendChild(nuevoInput);
}

document.getElementById('btnAgregarFecha').addEventListener('click', function(event) {
    event.preventDefault();
    agregarFecha();
});

document.getElementById('botonAceptar').addEventListener('click', function(event) {
    event.preventDefault();
    const fechasInputs = document.querySelectorAll('input[name="nuevaFecha[]"]');
    const fechasSeleccionadas = [];
    fechasInputs.forEach(input => {
        if (input.value) {
            const fecha = new Date(input.value);
            const dia = String(fecha.getUTCDate()).padStart(2, '0');
            const mes = String(fecha.getUTCMonth() + 1).padStart(2, '0'); // Los meses en JavaScript van de 0 a 11
            const ano = fecha.getUTCFullYear();
            const fechaFormateada = `${ano}-${mes}-${dia}`;
            fechasSeleccionadas.push(fechaFormateada);
        }
    });

    if (fechasSeleccionadas.length === 0) {
        toastr.error("No se seleccionó una fecha.", "Error", {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: '5000'
        });
    } else {
        // Crear inputs ocultos para cada fecha seleccionada
        fechasSeleccionadas.forEach(fecha => {
            const inputOculto = document.createElement('input');
            inputOculto.type = 'hidden';
            inputOculto.name = 'nuevaFecha[]';
            inputOculto.value = fecha;
            document.getElementById('formDiasNoLaborables').appendChild(inputOculto);
        });

        document.getElementById('formDiasNoLaborables').submit();
    }
});
