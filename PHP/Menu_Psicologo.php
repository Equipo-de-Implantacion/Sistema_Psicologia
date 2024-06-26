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


    <link rel="icon" href="../imagenes/favicon-16x16.png" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="../CSS/Calendario.css" rel="stylesheet">
    <link href="../fullcalendar/lib/main.min.css" rel="stylesheet">
    <link href="../CSS/Solicitud_Citas.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/menulateral.css">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    

</head>
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

  
    <div class="Contenido_Principal" id="Contenido_Principal">
        <div class="mi-logo"></div>

          <!-- Mostrar el nombre del usuario -->
    <div class="Nombre_Usuario display-3 fw-bold lh-1 ">
        <?php
        if (isset($_SESSION['Usuario'])) {
            echo "Bienvenido, " . $_SESSION['Usuario'];
        }
        ?>
    </div>

        <div id="Contenido_Calendario"></div> 

        <div class="Contenedor_Citas" id="Contenedor_Citas">

            <h1 class="display-6 fw-bold lh-1 fs-6">SOLICITUD DE CITAS</h1>

            <div class="Citas_MayorEdad" id="Citas_MayorEdad">

                <h2 class="display-6 fw-bold lh-1 fs-6">CITAS INDIVIDUAL</h2>

                <form action="../Configuracion/ProcesarCita.php" method="post">

                <div class="table-responsive"> <!-- Añade la clase table-responsive aquí -->

                        <table class="table table-responsive table-bordered border-dark table-hover text-center text-capitalize">
                        <tr class="table-dark table-active text-upperacase">
                            <th colspan="6">Paciente</th>
                            <th colspan="4">Cita</th>
                            <th rowspan="2">Operación</th>
                        </tr>
                        <tr class="table-dark table-active text-upperacase">
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
                            require '../Configuracion/SolicitudCitas.php';
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
            </div>

            <div class="Citas_MenorEdad">
                <br>
                <h2 class="display-6 fw-bold lh-1 fs-6">CITA INFANTIL O ADOLESCENTE</h2>
                <div class="table-responsive"> <!-- Añade la clase table-responsive aquí -->
                            
                <table class="table table-responsive table-bordered border-dark table-hover text-center text-capitalize">
                    <tr class="table-dark table-active text-upperacase">
                        <th colspan="3">Representante</th>
                        <th colspan="6">Paciente</th>
                        <th colspan="4">Cita</th>
                        <th rowspan="2">Operación</th>
                    </tr>
                    <tr class="table-dark table-active text-upperacase">
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
                        require '../Configuracion/SolicitudCitas.php';
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

            </div>
            <!--<input type="submit" value="Enviar">-->
            <input type="submit" class="btn btn-primary mi-boton" name="accion_aceptar" value="ACEPTAR">
            <input type="submit"  class="btn btn-primary mi-boton" name="accion_cancelar" value="CANCELAR">
            </form>
        </div>

    </div>
    </main>

    <script src="../fullcalendar/lib/main.js"></script>
    <script src="../fullcalendar/lib/locales/es.js"></script>
    <script src="../JS/Calendario.js"></script>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="../JS/menulateral.js"></script>

    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        if (params.has('error')) {
            const error = params.get('error');
            let message = '';
            switch (error) {
                case 'error_acceso':
                    message = 'Acceso denegado. Por favor inicie sesión.';
                    break;
                case 'Mas_de_dos_citas':
                    message = 'Solo se puede modificar una cita a la vez.';
                    break;
                case 'Seleccione_Cita':
                    message = 'Por favor seleccione una cita.';
                    break;
                case 'No_Seleccionado':
                    message = 'No se ha seleccionado ninguna cita.';
                    break;
                case 'Error_al_eliminar_Cita':
                    message = 'Error al eliminar la cita.';
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
        }

        if (params.has('success')) {
            const success = params.get('success');
            let message = '';
            switch (success) {
                case 'Cita_Eliminada':
                    message = 'La cita ha sido eliminada exitosamente.';
                    break;
                case 'Cita_Cancelada':
                    message = 'La cita ha sido cancelada exitosamente.';
                    break;
                    case 'Cita_Aceptada':
                    message = 'La cita ha sido aceptada exitosamente. Le llegará un correo electrónico';
                    break;
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





</body>

</html>