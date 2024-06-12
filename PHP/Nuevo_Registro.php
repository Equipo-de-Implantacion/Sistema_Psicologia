<?php
session_start();
include_once('../Configuracion/Conexion_BD.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emoción Vital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/menulateral.css">
    <link rel="stylesheet" href="../CSS/nuevoregistro.css">
    <link rel="icon" href="../imagenes/favicon-16x16.png" type="image/x-icon">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body>


  <!-- Comienzo del menu -->

  <div class="menu">
        <ion-icon name="menu-outline"></ion-icon>
        <ion-icon name="close-outline"></ion-icon>
    </div>

    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <ion-icon id="burguer" name="menu-outline"></ion-icon>
            </div>

        </div>

        <nav class="navegacion">
            <ul>
            <li>
            <a id="inbox" href="Menu_Psicologo.php">
                <ion-icon name="home-outline"></ion-icon>
                <span>Inicio</span>
            </a>
        </li>
        <li>
            <a href="Agendar_Cita.php">
                <ion-icon name="reader-outline"></ion-icon>
                <span>Agendar Cita</span>
            </a>
        </li>
        <li>
            <a href="Citas_Psicologo.php">
                <ion-icon name="newspaper-outline"></ion-icon>
                <span>Citas Agendadas</span>
            </a>
        </li>
        <li>
            <a href="Historial_Clinico.php">
                  <ion-icon name="id-card-outline"></ion-icon>
                <span>Historial Clinico</span>
            </a>
        </li>
        <li>
            <a href="Nuevo_Registro.php">
                <ion-icon name="document-text-outline"></ion-icon>
                <span>Registrar Usuario</span>
            </a>
        </li>
        <li>
            <a href="Configuracion_Psicologo.php">
                <ion-icon name="options-outline"></ion-icon>
                <span>Configuración</span>
            </a>
        </li>
      

                </li>
                <a href="CerrarSesion.php" class="sidebar-link">
                    <ion-icon name="log-out-outline"></ion-icon>
                    <span>Cerrar sesión</span>
                </a>
                </li>
        </nav>

    </div>
    <!-- Final del menu  -->

    <main>
    <div class="Contenido_Principal">
        <div class="form-container">

            <form action="../Configuracion/NuevoRegistro.php" method="POST">
                <h2 class="display-7 fw-bolder lh-1 fs-5">DATOS DEL USUARIO</h2>

                <select name="Tipo_Usuario" id="Tipo_Usuario" class="form-select" required>
                    <option value="" disabled selected>Selecciona el tipo de usuario</option>
                    <option value="1">Paciente</option>
                    <option value="2">Psicologo</option>
                </select>

                <input type="text" id="Usuario" name="Usuario" class="form-control" placeholder="Nombre de Usuario" required>

                <input type="password" id="Contrasena" name="Contrasena" class="form-control" placeholder="Contraseña" required>

                <input type="password" id="RContrasena" name="RContrasena" class="form-control" placeholder="Repetir Contraseña" required>

                <button type="submit"id="btn_registrar" class="btn btn-primary mi-boton">REGISTRAR USUARIO</button>
        </div>

        <div class="titulos">
            
            <h1 class="display-5 fw-bold lh-1">REGISTRE UN NUEVO USUARIO</h1>
            <div class="Nombre_Usuario">
                <?php
                    if (isset($_SESSION['Usuario'])) {
                    echo "Bienvenido, " . $_SESSION['Usuario'];
                    }
                ?>
            </div>
            <p>Registre un nuevo usuario aquí.</p>
        </div>

    <!-- Formulario Psicólogo -->
    <div class="Formulario_Psicologo">
        <br>
        <div class="row">
            <!-- Columna 1 -->
            <div class="col-md-4">
                <h2 class="display-7 fw-bolder lh-1 fs-5">DATOS DEL PSICÓLOGO</h2>
                <select name="Tipo_Documento" id="Tipo_Documento" class="form-select e">
                    <option value="" disabled selected>Tipo de Documento</option>
                    <option value="V-">Venezolano</option>
                    <option value="J-">Jurídico</option>
                    <option value="E-">Extranjero</option>
                </select>
                <input type="text" class="form-control e" name="Documento_Id" placeholder="Documento de Identidad" oninput="soloNumerosGuionesYPuntos(this)">
                <input type="text" class="form-control e" name="Primer_Nombre" id="Primer_Nombre" placeholder="Primer Nombre" oninput="soloLetras(this)">
                <input type="text" class="form-control e" name="Segundo_Nombre" id="Segundo_Nombre" placeholder="Segundo Nombre" oninput="soloLetras(this)">
                <input type="text" class="form-control e" name="Primer_Apellido" id="Primer_Apellido" placeholder="Primer Apellido" oninput="soloLetras(this)">
                <input type="text" class="form-control e" name="Segundo_Apellido" id="Segundo_Apellido" placeholder="Segundo Apellido" oninput="soloLetras(this)">
            </div>
            <!-- Columna 2 -->
            <div class="col-md-4">
                <h2 class="display-7 fw-bolder lh-1 fs-5">FECHA DE NACIMIENTO</h2>
                <input type="date" class="form-control e" name="Fecha_Nacimiento" id="Fecha_Nacimiento">
                <input type="text" class="form-control e" name="Telefono" id="Telefono" placeholder="Número de Teléfono" oninput="validarTelefono(this)">
                <input type="email" class="form-control e" name="Correo" id="Correo" placeholder="Correo electrónico" onblur="validarCorreo(this)">
                <select name="Sexo" id="Sexo" class="form-select e">
                    <option value="" disabled selected>Seleccione sexo</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Otro">Otro</option>
                </select>
                <input type="text" class="form-control e" name="Profesion" id="Profesion" placeholder="Profesión" oninput="soloLetras(this)">
                <input type="text" class="form-control e" name="Especialidad" id="Especialidad" placeholder="Especialidad" oninput="soloLetras(this)">
            </div>
            <!-- Columna 3 -->
            <div class="col-md-4">
                <h2 class="display-7 fw-bolder lh-1 fs-5">DIRECCIÓN</h2>
                <select id="Estado" name="Estado" class="form-select e">
                    <option value="" disabled selected>Seleccione Estado</option>
                </select>
                <select id="Municipio" name="Municipio" class="form-select e">
                    <option value="" disabled selected>Seleccione Municipio</option>
                </select>
                <select id="Parroquia" name="Parroquia" class="form-select e">
                    <option value="" disabled selected>Seleccione Parroquia</option>
                </select>
                <select id="Ciudad" name="Ciudad" class="form-select e">
                    <option value="" disabled selected>Seleccione Ciudad</option>
                </select>
                <input type="text" class="form-control e" name="Direccion_Vivienda" id="Direccion_Vivienda" placeholder="Dirección de vivienda">
            </div>
        </div>
    </div>
     </form>
</div>

</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        if (params.has('error')) {
            const error = params.get('error');
            let message = '';
            switch (error) {
                case 'campos_vacios':
                    message = 'Por favor, completa todos los campos.';
                    break;
                case 'contrasenas_no_coinciden':
                    message = 'Las contraseñas no coinciden.';
                    break;
                case 'usuario_existente':
                    message = 'El nombre de usuario ya está en uso.';
                    break;
                case 'Error_Registro':
                    message = 'Error al procesar el registro.';
                    break;
            }
            if (message) {
                toastr.error(message, 'Error', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: '5000'
                });
            }
        } else {
            // Mostrar la alerta de registro exitoso si corresponde
            if (localStorage.getItem('showConfirmationToast') === 'true') {
                toastr.success('¡Registro exitoso!', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: '5000',
                    showMethod: 'fadeIn',
                    hideMethod: 'fadeOut'
                });
                localStorage.removeItem('showConfirmationToast');
            }
        }
    });

    // Listener para el botón de registrar
    document.querySelector('#btn_registrar').addEventListener('click', () => {
        localStorage.setItem('showConfirmationToast', 'true');
    });
</script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="../JS/menulateral.js"></script>
    <script src="../JS/Validaciones.js"></script>
    <script src="../JS/CargarDireccion.js"></script>
    <script src="../JS/NuevoRegistro.js"></script>
   
</body>

</html>
