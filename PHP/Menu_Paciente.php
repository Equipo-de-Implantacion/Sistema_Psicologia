<?php
session_start();
include_once('../Configuracion/Conexion_BD.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emoción Vital</title>
</head>

<body>


    <!-- Mostrar el nombre del usuario -->
    <div class="Nombre_Usuario">
        <?php
        if (isset($_SESSION['Usuario'])) {
            echo "Bienvenido, " . $_SESSION['Usuario'];
        }
        ?>
    </div>

    <div class="Menu_Lateral" id="Menu_Lateral">
        <img src="" alt="">
        <ul>
            <li><a href="Menu_Paciente.php">Inicio</a></li>
            <li><a href="Citas_Agendadas.php">Citas Agendadas</a></li>
            <li><a href="Configuracion_Paciente.php">Configuración</a></li>
            <li><a href="CerrarSesion.php">Cerrar Sesión</a></li>
        </ul>
    </div>

    <div class="Contenido_Principal" id="Contenido_Principal">

        <h1>Pasos para Agendar tu Cita</h1>

        <p>Pasos para agendar tu cita:

            1. Seleccionar tipo de consulta
            2. Ingresar tus datos
            3. Seleccionar horario
            4. Confirmar tu cita</p>

        <a href="Agendar_Cita.php">Agendar Cita</a>

    </div>



</body>

</html>