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
    <link href="../CSS/Citas_Agendadas.css" rel="stylesheet">
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

    <main>
        <h1>CITAS AGENDADAS</h1>
        <p>Verifica y/o modifica tus citas agendadas aquí.</p>

        <div class="Contenedor_Citas">
            <h2>CITAS INDIVIDUAL</h2>
            <form action="../Configuracion/ProcesarCita.php" method="post">

                <div class="Citas_MayorEdad">
                    <table>
                        <tr>
                            <th colspan="6">Paciente</th>
                            <th colspan="4">Cita</th>
                            <th rowspan="2">Operación</th>
                        </tr>
                        <tr>
                            <th colspan="2">Identificación</th>
                            <th colspan="2">Nombres</th>
                            <th colspan="2">Apellidos</th>
                            <th>Tipo</th>
                            <th>Hora</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                        <tr>
                            <?php
                            require '../Configuracion/CitasAgendadas.php';
                            if (mysqli_num_rows($Resultado1) > 0) {
                                // Mostrar los datos de cada fila
                                while ($Fila = mysqli_fetch_assoc($Resultado1)) {
                                    echo "<tr>";
                                    echo "<td>" . $Fila["Tipo_Documento"] . "</td>";
                                    echo "<td>" . $Fila["Documento_Id"] . "</td>";
                                    echo "<td>" . $Fila["Primer_Nombre"] . "</td>";
                                    echo "<td>" . $Fila["Segundo_Nombre"] . "</td>";
                                    echo "<td>" . $Fila["Primer_Apellido"] . "</td>";
                                    echo "<td>" . $Fila["Segundo_Apellido"] . "</td>";

                                    echo "<td>" . $Fila["Tipo_Cita"] . "</td>";
                                    echo "<td>" . $Fila["Hora_Inicio"] . "</td>";
                                    echo "<td>" . $Fila["Dia"] . "</td>";
                                    echo "<td>" . $Fila["Status_Cita"] . "</td>";
                                    echo "<td><input type='checkbox' name='seleccionar[]' value='" . $Fila["Id_Paciente"] . "|" . $Fila["Id_Cita"] . "|" . $Fila["Id_Calendario"] . "|" . $Fila["Tipo_Cita"] .  "'></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='11'>No hay citas agendadas.</td></tr>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>

                <div class="Citas_MenorEdad">
                    <h2>CITA INFANTIL O ADOLESCENTE</h2>
                    <table>
                        <tr>
                            <th colspan="3">Representante</th>
                            <th colspan="6">Paciente</th>
                            <th colspan="4">Cita</th>
                            <th rowspan="2">Operación</th>
                        </tr>
                        <tr>
                            <th colspan="2">Identificación</th>
                            <th>Parentezco</th>
                            <th colspan="2">Identificación</th>
                            <th colspan="2">Nombres</th>
                            <th colspan="2">Apellidos</th>
                            <th>Tipo</th>
                            <th>Hora</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                        <tr>
                            <?php
                            require '../Configuracion/CitasAgendadas.php';
                            if (mysqli_num_rows($Resultado2) > 0) {
                                // Mostrar los datos de cada fila
                                while ($Fila = mysqli_fetch_assoc($Resultado2)) {
                                    echo "<tr>";
                                    echo "<td>" . $Fila["Tipo_Documento"] . "</td>";
                                    echo "<td>" . $Fila["Documento_Id"] . "</td>";
                                    echo "<td>" . $Fila["Parentezco"] . "</td>";

                                    echo "<td>" . $Fila["Tipo_Documento_Menor"] . "</td>";
                                    echo "<td>" . $Fila["Documento_Menor"] . "</td>";
                                    echo "<td>" . $Fila["Primer_Nombre"] . "</td>";
                                    echo "<td>" . $Fila["Segundo_Nombre"] . "</td>";
                                    echo "<td>" . $Fila["Primer_Apellido"] . "</td>";
                                    echo "<td>" . $Fila["Segundo_Apellido"] . "</td>";

                                    echo "<td>" . $Fila["Tipo_Cita"] . "</td>";
                                    echo "<td>" . $Fila["Hora_Inicio"] . "</td>";
                                    echo "<td>" . $Fila["Dia"] . "</td>";
                                    echo "<td>" . $Fila["Status_Cita"] . "</td>";
                                    echo "<td><input type='checkbox' name='seleccionar[]' value='" . $Fila["Id_Paciente"] . "|" . $Fila["Id_Cita"] . "|" . $Fila["Id_Calendario"] . "|" . $Fila["Tipo_Cita"] .  "'></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='14'>No hay citas agendadas.</td></tr>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
                <!--<input type="submit" value="Enviar">-->
                <input type="submit" name="accion_modificar" value="Modificar">
                <input type="submit" name="accion_eliminar" value="Eliminar">
            </form>

        </div>

    </main>
</body>

</html>