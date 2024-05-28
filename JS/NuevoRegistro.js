document.addEventListener('DOMContentLoaded', function () {
    const tipoUsuario = document.getElementById('Tipo_Usuario');
    const formularioPsicologo = document.querySelector('.Formulario_Psicologo');

    tipoUsuario.addEventListener('change', function () {
        if (this.value === '2') { 
            // Si el tipo de usuario es Psicólogo muestra el div de formulario
            formularioPsicologo.style.display = 'block';
        } else {
            formularioPsicologo.style.display = 'none';
        }
    });
    //Para ocultar div cuando se inicia
    formularioPsicologo.style.display = 'none';
});
