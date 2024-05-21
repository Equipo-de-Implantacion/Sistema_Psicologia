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
            <li><a href="Menu_Psicologo.php">Inicio</a></li>
            <li><a href="Agendar_Cita.php">Agendar Cita</a></li>
            <li><a href="Citas_Psicologo.php">Citas Agendadas</a></li>
            <li><a href="Historial_Clinico.php">Historial Clinico</a></li>
            <li><a href="Nuevo_Registro.php">Registrar Usuario</a></li>
            <li><a href="Configuracion_Psicologo.php">Configuración</a></li>
            <li><a href="CerrarSesion.php">Cerrar Sesión</a></li>
        </ul>
    </div>


        <main>
            <form action="../Configuracion/NuevoRegistro.php" method="POST">
                <h2>Datos de Usuario</h2>

                <label for="Tipo_Usuario">Seleccione el tipo de usuario</label>
                <select name="Tipo_Usuario" id="Tipo_Usuario" required>
                    <option value="" disabled selected>Selecciona el tipo de usuario</option>
                    <option value="1">Paciente</option>
                    <option value="2">Psicologo</option>
                </select>

                <label for="Usuario">Nombre de Usuario</label>
                <input type="text" id="Usuario" name="Usuario" placeholder="Usuario" required>

                <label for="Contrasena">Contraseña</label>
                <input type="password" id="Contrasena" name="Contrasena" placeholder="Contraseña" required>

                <label for="RContrasena">Repetir Contraseña</label>
                <input type="password" id="RContrasena" name="RContrasena" placeholder="Repetir Contraseña" required>

                <button type="submit">Registrar</button>
            </form>
        </main>
    </div>

</body>

</html>