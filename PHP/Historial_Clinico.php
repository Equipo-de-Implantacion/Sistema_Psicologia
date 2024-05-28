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
    <link href="../CSS/Obtener_Historial.css" rel="stylesheet">
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
        <h1>CREAR HISTORIAL</h1>
        <p>Buscar Paciente</p>
        <div class="Seleccione_Paciente">
            <form id="BusquedaPaciente" action="../Configuracion/BusquedaPaciente.php" method="POST">
                <input type="text" id="Identificacion" name="Identificacion">
                <button id="btn_Identificacion" name="btn_Identificacion">Buscar</button>
            </form>

            <!-- Mostrar los resultados -->
            <table id="resultadoTabla">
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($_SESSION['datos_paciente']) && !empty($_SESSION['datos_paciente'])) : ?>
                        <?php foreach ($_SESSION['datos_paciente'] as $dato) : ?>
                            <tr data-href="Nuevo_Historial.php?Id_Paciente=<?php echo $dato['Id_Paciente']; ?>">
                                <td><?php echo $dato['Identificacion']; ?></td>
                                <td><?php echo $dato['Nombre']; ?></td>
                                <td><?php echo $dato['Apellido']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Mostrar datos de paciente_menoredad -->
                    <?php if (isset($_SESSION['datos_menoriedad']) && !empty($_SESSION['datos_menoriedad'])) : ?>
                        <?php foreach ($_SESSION['datos_menoriedad'] as $dato) : ?>
                            <tr data-href="Nuevo_Historial.php?Id_Paciente=<?php echo $dato['Id_Paciente']; ?>">
                                <td><?php echo $dato['Identificacion']; ?></td>
                                <td><?php echo $dato['Nombre']; ?></td>
                                <td><?php echo $dato['Apellido']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>

    </main>

    <script src="../JS/SeccionPaciente.js"></script>

</body>

</html>