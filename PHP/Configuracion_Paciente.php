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
</head>

<body>

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


    <div class="Contenido_Principal">
        <h1>Configuración de Cuenta</h1>
        <p>Verifica y/o actualiza tus datos aquí.</p>
        <form action="../Configuracion/ConfiguracionPaciente.php" method="POST">

            <h2>Modificar Nombre de Usuario</h2>
            
            <label for="Usuario">Nombre del usuario:</label>
            <input type="text" id="Usuario" name="Usuario">

            <h2>Modificar Contraseña</h2>

            <label for="Contrasena_Actual">Contraseña actual:</label>
            <input type="password" id="Contrasena_Actual" name="Contrasena_Actual">

            <label for="Contrasena_Nueva">Contraseña nueva:</label>
            <input type="password" id="Contrasena_Nueva" name="Contrasena_Nueva">

            <label for="Repite_Contrasena">Repite tu nueva contraseña:</label>
            <input type="password" id="Repite_Contrasena" name="Repite_Contrasena">

            <button type="submit" class="btn_Guardar" id="btn_Guardar">Guardar</button>
            <button type="submit" name="eliminarCuenta" class="btn_Eliminar" id="btn_Eliminar">Eliminar Cuenta</button>
        </form>

    </div>

</body>

</html>