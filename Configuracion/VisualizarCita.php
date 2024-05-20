<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once('Conexion_BD.php');
include('CargarDireccion.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

$Id_TipoUsuario = $_SESSION['Id_TipoUsuario'];

$Consulta = "SELECT Id_TipoUsuario FROM usuario WHERE Id_Usuario = '" . $_SESSION['Id_Usuario'] . "'";
$Resultado = $Conexion->query($Consulta);
$Fila = $Resultado->fetch_assoc();

// Determinar qué contenido mostrar en el menú lateral basado en Id_TipoUsuario
if ($Fila['Id_TipoUsuario'] == 1) { // Para un tipo de usuario 1 (ejemplo: administrador)
    $menuLateral = '
        <div class="Menu_Lateral" id="Menu_Lateral">
            <img src="" alt="">
            <ul>
                <li><a href="Dashboard_Admin.php">Dashboard</a></li>
                <li><a href="Usuarios.php">Gestionar Usuarios</a></li>
                <li><a href="Citas.php">Gestionar Citas</a></li>
                <li><a href="CerrarSesion.php">Cerrar Sesión</a></li>
            </ul>
        </div>';
} elseif ($Fila['Id_TipoUsuario'] == 2) { // Para un tipo de usuario 2 (ejemplo: paciente)
    $menuLateral = '
        <div class="Menu_Lateral" id="Menu_Lateral">
            <img src="" alt="">
            <ul>
            <li><a href="Menu_Psicologo.php">Inicio</a></li>
            <li><a href="Agendar_Cita.php">Agendar Cita</a></li>
            <li><a href="Citas_Psicologo.php">Citas Agendadas</a></li>
            <li><a href=" ">Historial Clinico</a></li>
            <li><a href=" ">Generar Factura</a></li>
            <li><a href=" ">Reportes</a></li>
            <li><a href=" ">Registrar Usuario</a></li>
            <li><a href=" ">Configuración</a></li>
            <li><a href="CerrarSesion.php">Cerrar Sesión</a></li>
            </ul>
        </div>';
} else {
    $menuLateral = '';
}


if (isset($_GET['idPaciente']) && isset($_GET['idCita']) && isset($_GET['idCalendario']) && isset($_GET['tipoCita'])) {
    $idPaciente = intval($_GET['idPaciente']);
    $idCita = intval($_GET['idCita']);
    $idCalendario = intval($_GET['idCalendario']);
    $tipoCita = $_GET['tipoCita'];
}

// Determinar el tipo de consulta según la cita
if ($tipoCita == 'Individual' || $tipoCita == 'Pareja') {
    $ConsultaPac = "SELECT * FROM paciente WHERE Id_Paciente = ?";
    $DeclaracionPac = $Conexion->prepare($ConsultaPac);
    $DeclaracionPac->bind_param("i", $idPaciente);
    $DeclaracionPac->execute();
    $ResultadoPac = $DeclaracionPac->get_result();
    $Paciente = $ResultadoPac->fetch_assoc();

    $idDireccion = $Paciente['Id_Direccion'];

    $ConsultaCita = "SELECT Id_Cita, Hora_Inicio FROM cita WHERE Id_Paciente = ?";

    $DeclaracionCita = $Conexion->prepare($ConsultaCita);
    $DeclaracionCita->bind_param("i", $idPaciente);
    $DeclaracionCita->execute();
    $ResultadoCita = $DeclaracionCita->get_result();
    $Cita = $ResultadoCita->fetch_assoc();
    $idCita = $Cita['Id_Cita'];

    $ConsultaCal = "SELECT Dia FROM calendario WHERE Id_Cita = ?";
    $DeclaracionCal = $Conexion->prepare($ConsultaCal);
    $DeclaracionCal->bind_param("i", $idCita);
    $DeclaracionCal->execute();
    $ResultadoCal = $DeclaracionCal->get_result();
    $Calendario = $ResultadoCal->fetch_assoc();


    $ConsultaDir = "SELECT * FROM direccionpaciente WHERE Id_Direccion = ?";
    $DeclaracionDir = $Conexion->prepare($ConsultaDir);
    $DeclaracionDir->bind_param("i", $idDireccion);
    $DeclaracionDir->execute();
    $ResultadoDir = $DeclaracionDir->get_result();
    $Direccion = $ResultadoDir->fetch_assoc();
} else if ($tipoCita == 'Infante' || $tipoCita == 'Adolescente') {
    $ConsultaPac = "SELECT * FROM paciente_menoredad WHERE Id_Paciente = ?";
    $DeclaracionPac = $Conexion->prepare($ConsultaPac);
    $DeclaracionPac->bind_param("i", $idPaciente);
    $DeclaracionPac->execute();
    $ResultadoPac = $DeclaracionPac->get_result();
    $Paciente = $ResultadoPac->fetch_assoc();

    $idDireccion = $Paciente['Id_Direccion'];
    $ConsultaCita = "SELECT Id_Cita, Hora_Inicio FROM cita WHERE  Id_PacienteMenor = ?";

    $DeclaracionCita = $Conexion->prepare($ConsultaCita);
    $DeclaracionCita->bind_param("i", $idPaciente);
    $DeclaracionCita->execute();
    $ResultadoCita = $DeclaracionCita->get_result();
    $Cita = $ResultadoCita->fetch_assoc();
    $idCita = $Cita['Id_Cita'];

    $ConsultaCal = "SELECT Dia FROM calendario WHERE Id_Cita = ?";
    $DeclaracionCal = $Conexion->prepare($ConsultaCal);
    $DeclaracionCal->bind_param("i", $idCita);
    $DeclaracionCal->execute();
    $ResultadoCal = $DeclaracionCal->get_result();
    $Calendario = $ResultadoCal->fetch_assoc();


    $ConsultaDir = "SELECT * FROM direccionpaciente WHERE Id_Direccion = ?";
    $DeclaracionDir = $Conexion->prepare($ConsultaDir);
    $DeclaracionDir->bind_param("i", $idDireccion);
    $DeclaracionDir->execute();
    $ResultadoDir = $DeclaracionDir->get_result();
    $Direccion = $ResultadoDir->fetch_assoc();
} else {
    if ($Id_TipoUsuario == 1) {
        header("Location: ../PHP/Citas_Agendadas.php?error=Tipo_Cita_No_Válido");
    } else if ($Id_TipoUsuario == 2) {
        header("Location: ../PHP/Citas_Psicologo.php?error=Tipo_Cita_No_Válido");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emocion Vital</title>
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
        <?php echo $menuLateral; ?>
    </div>


    <main>
        <form method="POST" action="ModificarCita.php">
            <input type="hidden" name="idPaciente" value="<?php echo $idPaciente; ?>">
            <input type="hidden" name="idDireccion" value="<?php echo $idDireccion; ?>">
            <input type="hidden" name="idCita" value="<?php echo $idCita; ?>">
            <div class="Datos_Modificar">
                <div class="Datos_Paciente">
                    <h2>DATOS DEL PACIENTE</h2>
                    <label for="Tipo_Documento">Tipo de Documento</label>
                    <select name="Tipo_Documento" id="Tipo_Documento" readonly onmousedown="return false;">
                        <option value="" disabled selected>Tipo de Documento </option>
                        <option value="V-" <?php echo $Paciente['Tipo_Documento'] == 'V-' ? 'selected' : ''; ?>>Venezolano</option>
                        <option value="J-" <?php echo $Paciente['Tipo_Documento'] == 'J-' ? 'selected' : ''; ?>>Jurídico</option>
                        <option value="E-" <?php echo $Paciente['Tipo_Documento'] == 'E-' ? 'selected' : ''; ?>>Extranjero</option>
                    </select>

                    <label for="Documento_Id">Documento de Identidad</label>
                    <input type="text" name="Documento_Id" placeholder="Documento de Identidad" value="<?php echo $Paciente['Documento_Id']; ?>" readonly onmousedown="return false;">

                    <!--CAMPO DE CITA INFANTIL O ADOLESCENTE-->
                    <div class="Datos_Menor" id="Datos_Menor" <?php echo $tipoCita == 'Individual' || $tipoCita == 'Pareja' ? 'style="display: none;"' : ''; ?>>
                        <label for="Tiene_Documento">¿El paciente tiene documento de identificación?</label>
                        <input type="checkbox" id="Tiene_Documento" name="Tiene_Documento">

                        <label for="Tipo_Documento_Menor">Tipo de Documento del Menor</label>
                        <select name="Tipo_Documento_Menor" id="Tipo_Documento_Menor" readonly onmousedown="return false;">
                            <option value="" disabled selected>Tipo de Documento del Menor</option>
                            <option value="V-" <?php echo $Paciente['Tipo_Documento'] == 'V-' ? 'selected' : ''; ?>>Venezolano</option>
                            <option value="J-" <?php echo $Paciente['Tipo_Documento'] == 'J-' ? 'selected' : ''; ?>>Jurídico</option>
                            <option value="E-" <?php echo $Paciente['Tipo_Documento'] == 'E-' ? 'selected' : ''; ?>>Extranjero</option>
                        </select>

                        <label for="Documento_Menor">Documento de Identidad del Menor</label>
                        <input type="text" name="Documento_Menor" placeholder="Documento de Identidad" value="<?php echo $Paciente['Documento_Menor']; ?>" readonly onmousedown="return false;">

                        <label for="Parentezco">Parentezco</label>
                        <input type="text" name="Parentezco" id="Parentezco" value="<?php echo $Paciente['Parentezco']; ?>">
                    </div>

                    <label for="Primer_Nombre">Primer Nombre</label>
                    <input type="text" name="Primer_Nombre" id="Primer_Nombre" placeholder="Primer Nombre" value="<?php echo $Paciente['Primer_Nombre']; ?>" required oninput="soloLetras(this)">

                    <label for="Segundo_Nombre">Segundo Nombre</label>
                    <input type="text" name="Segundo_Nombre" id="Segundo_Nombre" placeholder="Segundo Nombre" value="<?php echo $Paciente['Segundo_Nombre']; ?>" oninput="soloLetras(this)">

                    <label for="Primer_Apellido">Primer Apellido</label>
                    <input type="text" name="Primer_Apellido" id="Primer_Apellido" placeholder="Primer Apellido" value="<?php echo $Paciente['Primer_Apellido']; ?>" required oninput="soloLetras(this)">

                    <label for="Segundo_Apellido">Segundo Apellido</label>
                    <input type="text" name="Segundo_Apellido" id="Segundo_Apellido" placeholder="Segundo Apellido" value="<?php echo $Paciente['Segundo_Apellido']; ?>" oninput="soloLetras(this)">

                    <label for="Fecha_Nacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="Fecha_Nacimiento" id="Fecha_Nacimiento" placeholder="Fecha de Nacimiento" value="<?php echo $Paciente['Fecha_Nacimiento']; ?>" required>

                    <label for="Telefono">Número de Teléfono</label>
                    <input type="text" name="Telefono" id="Telefono" placeholder="Número de Teléfono" value="<?php echo $Paciente['Telefono']; ?>" required oninput="validarTelefono(this)">

                    <label for="Correo">Correo Electrónico</label>
                    <input type="email" name="Correo" id="Correo" value="<?php echo $Paciente['Correo']; ?>" required onblur="validarCorreo(this)">

                    <label for="Sexo">Sexo</label>
                    <select name="Sexo" id="Sexo" required>
                        <option value="" disabled selected>Seleccione sexo</option>
                        <option value="Femenino" <?php echo $Paciente['Sexo'] == 'Femenino' ? 'selected' : ''; ?>>Femenino</option>
                        <option value="Masculino" <?php echo $Paciente['Sexo'] == 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
                    </select>

                    <div class="Datos_Mayor" id="Datos_Mayor" <?php echo $tipoCita == 'Infante' || $tipoCita == 'Adolescente' ? 'style="display: none;"' : ''; ?>>
                        <label for="Profesion">Profesion</label>
                        <input type="text" name="Profesion" id="Profesion" value="<?php echo $Paciente['Profesion']; ?>" oninput="soloLetras(this)">


                        <label for="Num_Hijos">Cantidad de Hijos</label>
                        <input type="text" name="Num_Hijos" id="Num_Hijos" value="<?php echo $Paciente['Num_Hijos']; ?>" oninput="soloNumeros(this)">
                    </div>


                    <h3>Dirección</h3>
                    <label for="Estado">Estado</label>
                    <select id="Estado" name="Estado" required>
                        <option value="" disabled selected>Seleccione Estado</option>
                        <option value="<?php echo $Direccion['id_estado']; ?>" <?php echo $Direccion['Id_Direccion'] == $Paciente['Id_Direccion'] ? 'selected' : ''; ?>><?php echo $Direccion['estado']; ?></option>
                    </select>

                    <label for="Municipio">Municipio</label>
                    <select id="Municipio" name="Municipio" required>
                        <option value="" disabled selected>Seleccione Municipio</option>
                        <option value="<?php echo $Direccion['id_municipio']; ?>" <?php echo $Direccion['Id_Direccion'] == $Paciente['Id_Direccion'] ? 'selected' : ''; ?>><?php echo $Direccion['municipio']; ?></option>
                    </select>


                    <label for="Parroquia">Parroquia</label>
                    <select id="Parroquia" name="Parroquia" required>
                        <option value="" disabled selected>Seleccione Parroquia</option>
                        <option value="<?php echo $Direccion['id_parroquia']; ?>" <?php echo $Direccion['Id_Direccion'] == $Paciente['Id_Direccion'] ? 'selected' : ''; ?>><?php echo $Direccion['parroquia']; ?></option>
                    </select>


                    <label for="Ciudad">Ciudad</label>
                    <select id="Ciudad" name="Ciudad" required>
                        <option value=" " disabled selected>Seleccione Ciudad </option>
                        <option value="<?php echo $Direccion['id_ciudad']; ?>" <?php echo $Direccion['Id_Direccion'] == $Paciente['Id_Direccion'] ? 'selected' : ''; ?>><?php echo $Direccion['ciudad']; ?></option>
                    </select>

                    <label for="Direccion_Vivienda">Dirección de vivienda</label>
                    <input type="text" name="Direccion_Vivienda" id="Direccion_Vivienda" value="<?php echo $Direccion['Direccion_Vivienda']; ?>" required>

                </div>

                <div class="Datos_Cita">
                    <h2>DATOS DE LA CITA</h2>
                    <label for="Servicio">Servicio:</label>
                    <select id="Servicio" name="Servicio" readonly onmousedown="return false;">
                        <option value="" disabled selected>Seleccione un servicio</option>
                        <option value="1" <?php echo $Paciente['Id_Cita'] == '1' ? 'selected' : ''; ?>>Psicoterapia Individual</option>
                        <option value="2" <?php echo $Paciente['Id_Cita'] == '2' ? 'selected' : ''; ?>>Psicoterapia para Pareja</option>
                        <option value="3" <?php echo $Paciente['Id_Cita'] == '3' ? 'selected' : ''; ?>>Psicoterapia Infantil</option>
                        <option value="4" <?php echo $Paciente['Id_Cita'] == '4' ? 'selected' : ''; ?>>Psicoterapia para Adolescentes</option>
                    </select>

                    <h3>Seleccione Fecha</h3>
                    <input type="date" name="Fecha" id="Fecha" value="<?php echo $Calendario['Dia']; ?>" required>

                    <h3>Seleccione Hora</h3>
                    <input type="time" name="Hora" id="Hora" value="<?php echo $Cita['Hora_Inicio']; ?>" required>

                </div>

            </div>
            <button type="submit">Modificar Datos</button>
        </form>
    </main>
    <script src="../JS/CargarDireccion.js"></script>
    <script src="../JS/AgendarCita.js"></script>
    <script src="../JS/Validaciones.js"></script>
</body>

</html>