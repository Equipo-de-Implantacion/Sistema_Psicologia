function soloLetras(input) {
    var regex = /^[A-Za-z]+$/;
    if (!regex.test(input.value)) {
        toastr.error('Solo se permiten letras');
        input.value = "";
    }
}


function soloNumeros(input) {
    var regex = /^[0-9]*$/;
    if (!regex.test(input.value)) {
        toastr.error('Solo se permiten números');

        input.value = "";
    }
}

function soloNumerosGuionesYPuntos(input) {
    var regex = /^[0-9.-]*$/;
    if (!regex.test(input.value)) {
        toastr.error('Solo se permiten números, guiones y puntos');

        input.value = "";
    }
}

function validarCorreo(input) {
    var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!regex.test(input.value)) {
        toastr.error('Correo electrónico inválido. Formato esperado: nombre@dominio.com');

        input.value = "";
    }
}


function validarTelefono(input) {
    var regex = /^[0-9-]+$/;
    if (!regex.test(input.value)) {
        toastr.error('Número de teléfono inválido. Solo se permiten números y un guion opcional');

        input.value = "";
    }
}




