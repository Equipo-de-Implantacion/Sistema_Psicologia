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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/menulateral.css">
    
    <link href="../CSS/Citas_Agendadas.css" rel="stylesheet">


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


<div class="Contenedor_Citas">


<img src="../imagenes/lOGO PSICOLOGIA FULL BLANCO.png" alt="Logo" class="mi-logo">

            <div class="partedearriba">

            <h1 class="display-6 fw-bold lh-1">CITAS AGENDADAS</h1>
            <div class="Nombre_Usuario">
                <?php
                    if (isset($_SESSION['Usuario'])) {
                        echo "Bienvenido, " . $_SESSION['Usuario'];
                    }
                ?>
            </div>
            <p>Verifica y/o modifica tus citas agendadas aquí.</p>
            </div>

    <form action="../Configuracion/ProcesarCita.php" method="post">

        <div class="Citas_MayorEdad">
            <h2 class="display-6 fw-bold lh-1 fs-6">CITAS INDIVIDUAL</h2>
            <div class="table-responsive"> <!-- Añade la clase table-responsive aquí -->
                <table class="table table-responsive table-bordered border-dark table-hover text-center text-capitalize"> <!-- Añade la clase table aquí -->
                    <!-- El contenido de tu tabla va aquí -->
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
        </div>
        
        <div class="Citas_MenorEdad">
        <h2 class="display-6 fw-bold lh-1 fs-6">CITA INFANTIL O ADOLESCENTE</h2>
            <div class="table-responsive"> <!-- Añade la clase table-responsive aquí -->
                <table class="table table-responsive table-bordered border-dark table-hover text-center text-capitalize""> <!-- Añade la clase table aquí -->
                    <!-- El contenido de tu tabla va aquí -->
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
            </div>

        <!--<input type="submit" value="Enviar">-->
        <input type="submit" name="accion_modificar" value="Modificar" class="btn btn-primary mi-boton">
        <input type="submit" name="accion_eliminar" value="Eliminar"class="btn btn-primary mi-boton">
    </form>

</div>

</main>


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
<script>
   document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    if (params.has('success')) {
        const success = params.get('success');
        if (success === 'Cita_Actualizada_Exitosamente') {
            toastr.success('¡La cita ha sido actualizada exitosamente!.', 'Éxito', {
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