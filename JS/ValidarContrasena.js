function validarContrasena(input) {
    const password = input.value;
    const regex = /^(?=.*[A-Z]).{6,}$/; // Expresión regular simplificada

    if (!regex.test(password)) {
        alert('La contraseña debe tener al menos 6 caracteres y una letra mayúscula.');
        input.value = ''; // Limpiar el campo de contraseña
        return false;
    }
}
