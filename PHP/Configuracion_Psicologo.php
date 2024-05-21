<?php
session_start();
include_once('../Configuracion/Conexion_BD.php');

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
    <link href="../CSS/Configuracion_Psicologo.css" rel="stylesheet">
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
            <li><a href="Menu_Psicologo.php">Inicio</a></li>
            <li><a href="Agendar_Cita.php">Agendar Cita</a></li>
            <li><a href="Citas_Psicologo.php">Citas Agendadas</a></li>
            <li><a href="Historial_Clinico.php">Historial Clinico</a></li>
            <li><a href="Nuevo_Registro.php">Registrar Usuario</a></li>
            <li><a href="Configuracion_Psicologo.php">Configuración</a></li>
            <li><a href="CerrarSesion.php">Cerrar Sesión</a></li>
        </ul>
    </div>


    <div class="Contenido_Principal">

        <form action="../Configuracion/ConfiguracionPsicologo.php" method="POST">
            <div class="Modificar_Datos">
                <h1>Configuración de Cuenta</h1>
                <p>Verifica y/o actualiza tus datos aquí.</p>

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
            </div>
        </form>

        <div class="Actualizar_Precios">
            <form action="../Configuracion/CostoCita.php" method="POST">
                <h1>Actualizar Precio de Consultas</h1>
                <?php
                require '../Configuracion/CostoCita.php';
                echo '<label for="Individual">Precio de Cita Individual</label>';
                echo '<input type="text" id="Individual" name="Individual" value="' . $costoIndividual . '">';

                echo '<label for="Infantil">Precio de Cita Infantil</label>';
                echo '<input type="text" id="Infantil" name="Infantil" value="' . $costoInfantil . '">';

                echo '<label for="Adolescente">Precio de Cita Adolescente</label>';
                echo '<input type="text" id="Adolescente" name="Adolescente" value="' . $costoAdolescente . '">';
                ?>
                <input type="submit" name="actualizar_precio" value="Actualizar">
            </form>
        </div>


        <div class="ModificarFechas">
            <form action="../Configuracion/ModificarFechas.php" method="POST">
                <h1>Días no laborables</h1>
                <label for="diasNoLaborables">Seleccione los días no laborables</label>
                <div id="contenedorFechas"></div>
                <button type="submit" class="botonAceptar" id="botonAceptar">Aceptar</button>
            </form>
            <button onclick="agregarFecha()">Agregar Fecha</button>
        </div>

        <div class="Dias_Nolaborables">
            <form action="../Configuracion/ModificarFechas.php" method="POST">
                <table>
                    <tr>
                        <th>Día</th>
                        <th>Fecha</th>
                        <th>Operación</th>
                    </tr>
                    <tr>
                        <?php
                        require '../Configuracion/ModificarFechas.php';
                        if (mysqli_num_rows($ResultadoDia) > 0) {
                            while ($Fila = mysqli_fetch_assoc($ResultadoDia)) {
                                echo "<tr>";
                                echo "<td>" . $Fila["DiaSemana"] . "</td>";
                                echo "<td>" . $Fila["Dia"] . "</td>";
                                echo "<td><input type='checkbox' name='diaSeleccionado[]' value='" . $Fila["Dia"] . "' /> </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No hay días.</td></tr>";
                        }
                        ?>
                    </tr>
                </table>
                <input type="submit" name="accion_cancelar" value="Cancelar">
            </form>
        </div>

    </div>
    <script src="../JS/ConfiguracionPsicologo.js"></script>

</body>

</html>