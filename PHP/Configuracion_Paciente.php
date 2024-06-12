<?php

include_once('../Configuracion/Conexion_BD.php');
include('../Configuracion/ConfiguracionPaciente.php');

// Inicio Sesion de usuario
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
    <link rel="stylesheet" href="../CSS/ConfiguracionPaciente.css">
    <link rel="icon" href="../imagenes/favicon-16x16.png" type="image/x-icon">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>

  
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
                    <a id="inbox" href="Menu_Paciente.php">
                        <ion-icon name="home-outline"></ion-icon>
                        <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="Citas_Agendadas.php">
                        <ion-icon name="reader-outline"></ion-icon>
                        <span>Citas Agendadas</span>
                    </a>
                </li>
                <li>
                    <a href="Configuracion_Paciente.php">
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

    <main>

   

    <div class="Contenido_Principal">


    

        <img src="../imagenes/lOGO PSICOLOGIA FULL BLANCO.png" alt="Logo" class="mi-logo">

        <div class="titulos">
            <h1 class="display-6 fw-bold lh-1">CONFIGURACIÓN DE CUENTA</h1>
            <div class="Nombre_Usuario">
                <?php
                    if (isset($_SESSION['Usuario'])) {
                    echo "Bienvenido, " . $_SESSION['Usuario'];
                    }
                ?>
            </div>

            <p>Verifica y/o actualiza tus datos aquí.</p>
            
        </div>
       

        <form action="../Configuracion/ConfiguracionPaciente.php" method="POST">
           
            <h2 class="display-6 fw-bold lh-1 fs-6">MODIFICA TU NOMBRE DE USUARIO</h2>
            
            <input type="text" id="Usuario" name="Usuario" class="form-control" placeholder="Nombre de usuario">

            <h2 class="display-6 fw-bold lh-1 fs-6">MODIFICA TU CONTRASEÑA</h2>

            <input type="password" id="Contrasena_Actual" name="Contrasena_Actual" class="form-control" placeholder="Contraseña actual">

            <input type="password" id="Contrasena_Nueva" name="Contrasena_Nueva"class="form-control"placeholder="Contraseña nueva">

            <input type="password" id="Repite_Contrasena" name="Repite_Contrasena"class="form-control" placeholder="Repetir contraseña">

            <button type="submit" class="btn_Guardar btn btn-primary mi-boton" id="btn_Guardar" >GUARDAR</button>
            <button type="submit" name="eliminarCuenta" class="btn_Eliminar btn_Guardar btn btn-primary mi-boton" id="btn_Eliminar">ELIMINAR CUENTA</button>
        </form>

    </div>

    </main>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        let message = '';

        if (params.has('error')) {
            const error = params.get('error');
            switch (error) {
                case 'error_acceso':
                    message = 'Acceso denegado. Por favor inicie sesión.';
                    break;
                
                case 'Nombre_usuario_existente':
                    message = 'El nombre de usuario ya existe.';
                    break;
                case 'Contraseñas_no_coinciden':
                    message = 'Las contraseñas no coinciden.';
                    break;
                case 'Contraseña_incorrecta':
                    message = 'La contraseña actual es incorrecta.';
                    break;
                default:
                    message = 'Ha ocurrido un error desconocido.';
            }
            if (message) {
                toastr.error(message, 'Error', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: '5000'
                });
            }
        }

        if (params.has('success')) {
            const success = params.get('success');
            switch (success) {
                
                case 'Nombre_usuario_actualizado':
                    message = 'El nombre de usuario ha sido actualizado exitosamente.';
                    break;
                case 'Contraseña_actualizada':
                    message = 'La contraseña ha sido actualizada exitosamente.';
                    break;
                default:
                    message = 'Operación completada exitosamente.';
            }
            if (message) {
                toastr.success(message, 'Éxito', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: '5000'
                });
            }
        }
    });
</script>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="../JS/menulateral.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>

</html>
