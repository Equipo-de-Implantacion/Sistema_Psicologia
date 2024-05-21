// Array para almacenar las fechas seleccionadas
var fechasSeleccionadas = [];

function agregarFecha() {
    // Crear un nuevo input de tipo date
    var nuevoInput = document.createElement("input");
    nuevoInput.type = "date";
    nuevoInput.id = "nuevaFecha";
    nuevoInput.name = "nuevaFecha[]";

    // Función para verificar si la fecha ya existe en el array
    var fechaYaExistente = function (fecha) {
        return fechasSeleccionadas.includes(fecha);
    };

    // Función para agregar la fecha al array y limpiar el input si es necesario
    var agregarYLimpiarSiDuplicado = function () {
        if (!fechaYaExistente(nuevoInput.value)) {
            fechasSeleccionadas.push(nuevoInput.value);
            alert("Fecha agregada exitosamente.");

        } else {
            alert("Esta fecha ya ha sido seleccionada.");
            nuevoInput.value = '';
        }
    };

    // Evento para manejar cuando el usuario selecciona una fecha
    nuevoInput.addEventListener('change', agregarYLimpiarSiDuplicado);

    // Obtener la fecha actual y formatearla como yyyy-mm-dd
    var hoy = new Date();
    var dia = String(hoy.getDate()).padStart(2, '0');
    var mes = String(hoy.getMonth() + 1).padStart(2, '0');
    var ano = hoy.getFullYear();

    // Establecer el valor mínimo del input al día actual
    nuevoInput.min = ano + '-' + mes + '-' + dia;

    // Agregar el nuevo input al contenedor
    var contenedor = document.getElementById('contenedorFechas');
    contenedor.appendChild(nuevoInput);

}









