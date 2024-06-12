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
if ($Fila['Id_TipoUsuario'] == 1) {
    $menuLateral = '


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
                    <a id="inbox" href="../PHP/Menu_Paciente.php">
                        <ion-icon name="home-outline"></ion-icon>
                        <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="../PHP/Citas_Agendadas.php">
                        <ion-icon name="reader-outline"></ion-icon>
                        <span>Citas Agendadas</span>
                    </a>
                </li>
                <li>
                    <a href="../PHP/Configuracion_Paciente.php">
                        <ion-icon name="options-outline"></ion-icon>
                        <span>Configuración</span>
                    </a>
                </li>

                </li>
                <a href="../PHP/CerrarSesion.php" class="sidebar-link">
                    <ion-icon name="log-out-outline"></ion-icon>
                    <span>Cerrar sesión</span>
                </a>
                </li>
        </nav>

    </div>
    <!-- Final del menu  -->
        
        ';
} elseif ($Fila['Id_TipoUsuario'] == 2) {
    $menuLateral = '

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
            <a id="inbox" href="../PHP/Menu_Psicologo.php">
                <ion-icon name="home-outline"></ion-icon>
                <span>Inicio</span>
            </a>
        </li>
        <li>
            <a href="../PHP/Agendar_Cita.php">
                <ion-icon name="reader-outline"></ion-icon>
                <span>Agendar Cita</span>
            </a>
        </li>
        <li>
            <a href="../PHP/Citas_Psicologo.php">
                <ion-icon name="newspaper-outline"></ion-icon>
                <span>Citas Agendadas</span>
            </a>
        </li>
        <li>
            <a href="../PHP/Historial_Clinico.php">
                  <ion-icon name="id-card-outline"></ion-icon>
                <span>Historial Clinico</span>
            </a>
        </li>
        <li>
            <a href="../PHP/Nuevo_Registro.php">
                <ion-icon name="document-text-outline"></ion-icon>
                <span>Registrar Usuario</span>
            </a>
        </li>
        <li>
            <a href="../PHP/Configuracion_Psicologo.php">
                <ion-icon name="options-outline"></ion-icon>
                <span>Configuración</span>
            </a>
        </li>
      

                </li>
                <a href="../PHP/CerrarSesion.php" class="sidebar-link">
                    <ion-icon name="log-out-outline"></ion-icon>
                    <span>Cerrar sesión</span>
                </a>
                </li>
        </nav>

    </div>
    <!-- Final del menu  -->
        
        ';
} else {
    $menuLateral = '';
}


if (isset($_GET['idPaciente']) && isset($_GET['idCita']) && isset($_GET['idCalendario']) && isset($_GET['tipoCita'])) {
    $idPaciente = intval($_GET['idPaciente']);
    $idCita = intval($_GET['idCita']);
    $idCalendario = intval($_GET['idCalendario']);
    $tipoCita = $_GET['tipoCita'];


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
    }

    if ($tipoCita == 'Infante' || $tipoCita == 'Adolescente') {
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
    }
} else {
    if ($Id_TipoUsuario == 1) {
        header("Location: ../PHP/Citas_Agendadas.php?error=Tipo_Cita_No_Válido");
    } else if ($Id_TipoUsuario == 2) {
        header("Location: ../PHP/Citas_Psicologo.php?error=Tipo_Cita_No_Válido");
    }
}


?>




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emocion Vital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/menulateral.css">
    <link rel="stylesheet" href="../CSS/visualizarcita.css">
    <link rel="icon" href="../imagenes/favicon-16x16.png" type="image/x-icon">




    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>


    <div class="Menu_Lateral" id="Menu_Lateral">
        <?php echo $menuLateral; ?>
    </div>



    <main>
        <form method="POST" action="ModificarCita.php">
            <input type="hidden" name="idPaciente" value="<?php echo $idPaciente; ?>">
            <input type="hidden" name="idDireccion" value="<?php echo $idDireccion; ?>">
            <input type="hidden" name="idCita" value="<?php echo $idCita; ?>">

            <div class="Datos_Modificar">
                <img src="../imagenes/lOGO PSICOLOGIA FULL BLANCO.png" alt="Logo" class="mi-logo">

                <div class="titulos">
                    <h1 class="display-6 fw-bold lh-1">MODIFICAR DATOS DE LA CITA</h1>
                    <div class="Nombre_Usuario">
                        <?php
                        if (isset($_SESSION['Usuario'])) {
                            echo "Bienvenido, " . $_SESSION['Usuario'];
                        }
                        ?>
                    </div>
                    <button type="submit" class="btn btn-primary mi-boton">MODIFICAR DATOS</button>

                </div>


                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="Datos_Paciente">
                            <h2 class="display-7 fw-bold lh-1 fs-4">DATOS PRINCIPALES</h2>
                            <div class="mb-3">
                                <label for="Tipo_Documento">Tipo de Documento</label>
                                <select name="Tipo_Documento" class="form-select" id="Tipo_Documento" readonly onmousedown="return false;">
                                    <option value="" disabled selected>Tipo de Documento</option>
                                    <option value="V-" <?php echo $Paciente['Tipo_Documento'] == 'V-' ? 'selected' : ''; ?>>Venezolano</option>
                                    <option value="J-" <?php echo $Paciente['Tipo_Documento'] == 'J-' ? 'selected' : ''; ?>>Jurídico</option>
                                    <option value="E-" <?php echo $Paciente['Tipo_Documento'] == 'E-' ? 'selected' : ''; ?>>Extranjero</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Documento_Id">Documento de Identidad</label>
                                <input type="text" class="form-control" name="Documento_Id" placeholder="Documento de Identidad" value="<?php echo $Paciente['Documento_Id']; ?>" readonly onmousedown="return false;">
                            </div>

                            <!-- CAMPO DE CITA INFANTIL O ADOLESCENTE -->
                            <div class="Datos_Menor" id="Datos_Menor" <?php echo $tipoCita == 'Individual' || $tipoCita == 'Pareja' ? 'style="display: none;"' : ''; ?>>
                                <div class="mb-3">
                                    <label for="Tiene_Documento">¿El paciente tiene documento de identificación?</label>
                                    <input type="checkbox" id="Tiene_Documento" name="Tiene_Documento" onchange="mostrarDocumento()">
                                </div>
                                <div class="mb-3">
                                    <label for="Tipo_Documento_Menor">Tipo de Documento del Menor</label>
                                    <select name="Tipo_Documento_Menor" class="form-select" id="Tipo_Documento_Menor" readonly onmousedown="return false;">
                                        <option value="" disabled selected>Tipo de Documento del Menor</option>
                                        <option value="V-" <?php echo $Paciente['Tipo_Documento'] == 'V-' ? 'selected' : ''; ?>>Venezolano</option>
                                        <option value="J-" <?php echo $Paciente['Tipo_Documento'] == 'J-' ? 'selected' : ''; ?>>Jurídico</option>
                                        <option value="E-" <?php echo $Paciente['Tipo_Documento'] == 'E-' ? 'selected' : ''; ?>>Extranjero</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="Documento_Menor">Documento de Identidad del Menor</label>
                                    <input type="text" class="form-control" name="Documento_Menor" placeholder="Documento de Identidad" value="<?php echo $Paciente['Documento_menor']; ?>" readonly onmousedown="return false;">
                                </div>
                                <div class="mb-3">
                                    <label for="Parentezco">Parentezco</label>
                                    <input type="text" class="form-control" name="Parentezco" id="Parentezco" value="<?php echo $Paciente['Parentezco']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Primer_Nombre">Primer Nombre</label>
                            <input type="text" class="form-control" name="Primer_Nombre" id="Primer_Nombre" placeholder="Primer Nombre" value="<?php echo $Paciente['Primer_Nombre']; ?>" required oninput="soloLetras(this)">
                        </div>
                        <div class="mb-3">
                            <label for="Segundo_Nombre">Segundo Nombre</label>
                            <input type="text" class="form-control" name="Segundo_Nombre" id="Segundo_Nombre" placeholder="Segundo Nombre" value="<?php echo $Paciente['Segundo_Nombre']; ?>" oninput="soloLetras(this)">
                        </div>
                        <div class="mb-3">
                            <label for="Primer_Apellido">Primer Apellido</label>
                            <input type="text" class="form-control" name="Primer_Apellido" id="Primer_Apellido" placeholder="Primer Apellido" value="<?php echo $Paciente['Primer_Apellido']; ?>" required oninput="soloLetras(this)">
                        </div>
                        <div class="mb-3">
                            <label for="Segundo_Apellido">Segundo Apellido</label>
                            <input type="text" class="form-control" name="Segundo_Apellido" id="Segundo_Apellido" placeholder="Segundo Apellido" value="<?php echo $Paciente['Segundo_Apellido']; ?>" oninput="soloLetras(this)">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <h2 class="display-7 fw-bold lh-1 fs-4">DATOS SECUNDARIOS</h2>

                        <div class="mb-3">
                            <label for="Fecha_Nacimiento">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" name="Fecha_Nacimiento" id="Fecha_Nacimiento" placeholder="Fecha de Nacimiento" value="<?php echo $Paciente['Fecha_Nacimiento']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Telefono">Número de Teléfono</label>
                            <input type="text" class="form-control" name="Telefono" id="Telefono" placeholder="Número de Teléfono" value="<?php echo $Paciente['Telefono']; ?>" required oninput="validarTelefono(this)">
                        </div>
                        <div class="mb-3">
                            <label for="Correo">Correo Electrónico</label>
                            <input type="email" class="form-control" name="Correo" id="Correo" value="<?php echo $Paciente['Correo']; ?>" required onblur="validarCorreo(this)">
                        </div>
                        <div class="mb-3">
                            <label for="Sexo">Sexo</label>
                            <select name="Sexo" class="form-select" id="Sexo" required>
                                <option value="" disabled selected>Seleccione sexo</option>
                                <option value="Femenino" <?php echo $Paciente['Sexo'] == 'Femenino' ? 'selected' : ''; ?>>Femenino</option>
                                <option value="Masculino" <?php echo $Paciente['Sexo'] == 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
                            </select>
                        </div>
                        <div class="Datos_Mayor" id="Datos_Mayor" <?php echo $tipoCita == 'Infante' || $tipoCita == 'Adolescente' ? 'style="display: none;"' : ''; ?>>
                            <div class="mb-3">
                                <label for="Profesion">Profesión</label>
                                <input type="text" class="form-control" name="Profesion" id="Profesion" value="<?php echo $Paciente['Profesion']; ?>" oninput="soloLetras(this)">
                            </div>
                            <div class="mb-3">
                                <label for="Num_Hijos">Cantidad de Hijos</label>
                                <input type="text" class="form-control" name="Num_Hijos" id="Num_Hijos" value="<?php echo $Paciente['Num_Hijos']; ?>" oninput="soloNumeros(this)">
                            </div>
                        </div>

                        <div class="Datos_Cita">
                            <h2 class="display-7 fw-bold lh-1 fs-4">DATOS DE LA CITA</h2>
                            <div class="mb-3">
                                <label for="Servicio">Servicio:</label>
                                <select id="Servicio" class="form-select" name="Servicio" readonly onmousedown="return false;">
                                    <option value="" disabled selected>Seleccione un servicio</option>
                                    <option value="1" <?php echo $Paciente['Id_Cita'] == '1' ? 'selected' : ''; ?>>Psicoterapia Individual</option>
                                    <option value="2" <?php echo $Paciente['Id_Cita'] == '2' ? 'selected' : ''; ?>>Psicoterapia para Pareja</option>
                                    <option value="3" <?php echo $Paciente['Id_Cita'] == '3' ? 'selected' : ''; ?>>Psicoterapia Infantil</option>
                                    <option value="4" <?php echo $Paciente['Id_Cita'] == '4' ? 'selected' : ''; ?>>Psicoterapia para Adolescentes</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <h5 class="display-7 fw-bold lh-1 fs-6">SELECCIONE FECHA</h5>
                                <input type="date" class="form-select" name="Fecha" id="Fecha" value="<?php echo $Calendario['Dia']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <h5 class="display-7 fw-bold lh-1 fs-6">SELECCIONE HORA</h5>
                                <input type="time" class="form-select" name="Hora" id="Hora" value="<?php echo $Cita['Hora_Inicio']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <h3 class="display-7 fw-bold lh-1 fs-4">DIRECCIÓN</h3>
                        <div class="mb-3">
                            <label for="Estado">Estado</label>
                            <select id="Estado" class="form-select" name="Estado" required>
                                <option value="" disabled selected>Seleccione Estado</option>
                                <option value="<?php echo $Direccion['id_estado']; ?>" <?php echo $Direccion['Id_Direccion'] == $Paciente['Id_Direccion'] ? 'selected' : ''; ?>><?php echo $Direccion['estado']; ?></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Municipio">Municipio</label>
                            <select id="Municipio" class="form-select" name="Municipio" required>
                                <option value="" disabled selected>Seleccione Municipio</option>
                                <option value="<?php echo $Direccion['id_municipio']; ?>" <?php echo $Direccion['Id_Direccion'] == $Paciente['Id_Direccion'] ? 'selected' : ''; ?>><?php echo $Direccion['municipio']; ?></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Parroquia">Parroquia</label>
                            <select id="Parroquia" class="form-select" name="Parroquia" required>
                                <option value="" disabled selected>Seleccione Parroquia</option>
                                <option value="<?php echo $Direccion['id_parroquia']; ?>" <?php echo $Direccion['Id_Direccion'] == $Paciente['Id_Direccion'] ? 'selected' : ''; ?>><?php echo $Direccion['parroquia']; ?></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Ciudad">Ciudad</label>
                            <select id="Ciudad" class="form-select" name="Ciudad" required>
                                <option value="" disabled selected>Seleccione Ciudad</option>
                                <option value="<?php echo $Direccion['id_ciudad']; ?>" <?php echo $Direccion['Id_Direccion'] == $Paciente['Id_Direccion'] ? 'selected' : ''; ?>><?php echo $Direccion['ciudad']; ?></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Direccion_Vivienda">Dirección de vivienda</label>
                            <input type="text" class="form-control" name="Direccion_Vivienda" id="Direccion_Vivienda" value="<?php echo $Direccion['Direccion_Vivienda']; ?>" required>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            if (params.has('error')) {
                const error = params.get('error');
                let message = '';
                switch (error) {
                    case 'Datos_Vacíos':
                        message = 'Error: Por favor, complete todos los campos.';
                        break;
                    case 'error_actualizar_paciente_mayor':
                        message = 'Error al actualizar la información del paciente mayor.';
                        break;
                    case 'error_actualizar_paciente_menor':
                        message = 'Error al actualizar la información del paciente menor.';
                        break;
                    case 'error_actualizar_cita':
                        message = 'Error al actualizar la cita.';
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

        });
    </script>



    <script src="../JS/CargarDireccion.js"></script>
    <script src="../JS/AgendarCita.js"></script>
    <script src="../JS/Validaciones.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../JS/menulateral.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>

</html>
