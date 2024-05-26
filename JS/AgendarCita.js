let seccionactual = 0;
const seccion = document.querySelectorAll('.Seccion');
const pasos = document.querySelectorAll('#Pasos li');

function ActualizarIndicadorPasos() {
    pasos.forEach(function (paso, index) {
        paso.classList.remove('pasos-activo', 'pasos-completado');
        paso.style.backgroundColor = '';
        paso.style.borderColor = '#3A3F35';
        if (paso.querySelector('.linea')) {
            paso.querySelector('.linea').style.width = '0';
            paso.querySelector('.linea').style.backgroundColor = '#BFBFBF';
        }
    });


    for (let i = 0; i < seccion.length; i++) {
        if (i < seccionactual) {
            pasos[i].classList.add('pasos-completado');
            pasos[i].style.backgroundColor = '#D0D0BD';
            pasos[i].style.borderColor = 'transparent';
            if (pasos[i].querySelector('.linea')) {
                pasos[i].querySelector('.linea').style.width = '100%';
                pasos[i].querySelector('.linea').style.backgroundColor = '#D0D0BD';
            }
        } else if (i === seccionactual) {
            pasos[i].classList.add('pasos-activo');
            if (pasos[i].querySelector('.linea')) {
                pasos[i].querySelector('.linea').style.backgroundColor = '#D0D0BD';
            }
        }
    }
}


function SiguientePaso() {
    var camposRequeridos = seccion[seccionactual].querySelectorAll('[required]');
    var todosLlenos = true;
    var camposOpcionales = ['Segundo_Nombre', 'Segundo_Apellido', 'Tipo_Cedula_Menor', 'Documento_Menor', 'Profesion', 'Num_Hijos'];

    camposRequeridos.forEach(function (campo) {
        // Verificar si el campo es opcional
        var esOpcional = camposOpcionales.includes(campo.name);

        if (!esOpcional && campo.value.trim() === '') {
            todosLlenos = false;
            campo.style.borderColor = 'red';
        } else {
            campo.style.borderColor = '';
        }
    });

    if (todosLlenos) {
        if (seccionactual < seccion.length - 1) {
            seccion[seccionactual].classList.remove('activa');
            seccionactual++;
            seccion[seccionactual].classList.add('activa');
            ActualizarIndicadorPasos();

            if (seccion[seccionactual].id === 'Confirmar_Cita') {
                document.getElementById('btn_Siguiente').style.display = 'none';
                document.getElementById('btn_Confirmar').style.display = 'block';
            } else {
                document.getElementById('btn_Siguiente').style.display = 'block';
                document.getElementById('btn_Confirmar').style.display = 'none';
            }
        }
    } else {
        alert('Por favor, complete todos los campos requeridos.');
    }
}

function AnteriorPaso() {
    if (seccionactual > 0) {
        seccion[seccionactual].classList.remove('activa');
        seccionactual--;
        seccion[seccionactual].classList.add('activa');
        ActualizarIndicadorPasos();

        if (seccion[seccionactual].id !== 'Confirmar_Cita') {
            document.getElementById('btn_Confirmar').style.display = 'none';
            document.getElementById('btn_Siguiente').style.display = 'block';
        }
    }
}

ActualizarIndicadorPasos();

//MOSTRAR FORMULARIO SEGÚN EL TIPO DE CITA
document.getElementById('Servicio').addEventListener('change', function () {
    var tipoCita = this.value;
    var Dato_Mayor = document.getElementById('Datos_Mayor');
    var Dato_Menor = document.getElementById('Datos_Menor');

    if (tipoCita === "3" || tipoCita === "4") {
        Dato_Mayor.style.display = 'none';
        Dato_Menor.style.display = 'block';
    } else {
        Dato_Mayor.style.display = 'block';
        Dato_Menor.style.display = 'none';
    }
});

function mostrarDocumento() {
    var tieneDocumento = document.getElementById('Tiene_Documento').checked;
    var documentoDiv = document.getElementById('Documento_Menor_Div');
    if (tieneDocumento) {
        documentoDiv.style.display = 'block';
    } else {
        documentoDiv.style.display = 'none';
    }
}

document.getElementById('Hora').addEventListener('change', function () {
    var horaSeleccionada = this.value;
    var horaMinima = "08:00";
    var horaMaxima = "17:00";
    var horaNoDeseadaInicio = "12:00";
    var horaNoDeseadaFin = "14:00";

    var horaSeleccionadaObj = new Date(`1970-01-01T${horaSeleccionada}:00`);
    var horaMinimaObj = new Date(`1970-01-01T${horaMinima}:00`);
    var horaMaximaObj = new Date(`1970-01-01T${horaMaxima}:00`);
    var horaNoDeseadaInicioObj = new Date(`1970-01-01T${horaNoDeseadaInicio}:00`);
    var horaNoDeseadaFinObj = new Date(`1970-01-01T${horaNoDeseadaFin}:00`);

    if (horaSeleccionadaObj < horaMinimaObj || horaSeleccionadaObj > horaMaximaObj) {
        alert('Por favor, selecciona una hora entre las 8:00 AM y las 5:00 PM.');
        this.value = '';
    } else if (horaSeleccionadaObj >= horaNoDeseadaInicioObj && horaSeleccionadaObj <= horaNoDeseadaFinObj) {
        alert('Lo sentimos, las citas no están disponibles entre las 12:00 PM y las 2:00 PM. Por favor, selecciona otra hora.');
        this.value = '';
    }
});

document.addEventListener('DOMContentLoaded', function () {
    var hoy = new Date();
    var dia = String(hoy.getDate()).padStart(2, '0');
    var mes = String(hoy.getMonth() + 1).padStart(2, '0'); // Los meses en JavaScript empiezan desde 0
    var ano = hoy.getFullYear();

    var fechaActual = ano + '-' + mes + '-' + dia;
    document.getElementById('Fecha').setAttribute('min', fechaActual);
});

//Validar año al agendar cita
document.getElementById('Fecha').addEventListener('blur', function(event) {
    var fechaInput = event.target;
    var fechaSeleccionada = new Date(fechaInput.value);
    var fechaActual = new Date();

    if (fechaSeleccionada < fechaActual) {
        alert('La fecha seleccionada debe ser igual o posterior al día actual.');
        fechaInput.min = fechaActual.toISOString().substring(0,10); // Formatea la fecha actual al formato yyyy-mm-dd
        fechaInput.value = fechaInput.min;
    }
});

document.getElementById('cancelarBtn').addEventListener('click', function () {
    if (confirm("¿Estás seguro de que quieres salir?")) {
        window.location.href = 'Agendar_Cita.php';
    }
});
