<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emoción Vital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/menulateral.css">
    <link href="../CSS/Configuracion_Psicologo.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
                <li>
                    <a href="CerrarSesion.php" class="sidebar-link">
                        <ion-icon name="log-out-outline"></ion-icon>
                        <span>Cerrar sesión</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- Final del menu -->

    <main>
        <div class="Contenido_Principal">
            <img src="../imagenes/lOGO PSICOLOGIA FULL BLANCO.png" alt="Logo" class="mi-logo">
            <div class="titulos">
                <h1 class="display-6 fw-bold lh-1">CONFIGURACIÓN DE CUENTA</h1>
                <div class="Nombre_Usuario">
                    <?php
                    if (isset($_SESSION['Usuario'])) {
                        echo "Bienvenido, " . $_SESSION['Usuario'];
                    }
                    ?>
                </div>
                <p>Verifica y/o actualiza tus datos aquí.</p>
            </div>

            <div class="row">
                <!-- Contenido de la segunda fila (actualizar precios) -->
                <div class="col">
                    <div class="Contenido_secundario">
                        <form action="../Configuracion/ConfiguracionPsicologo.php" method="POST">
                            <div class="Modificar_Datos">
                                <h4 class="display-6 fw-bold lh-1 fs-6">CONFIGURACIÓN GENERAL</h4>
                                <input type="text" id="Usuario" name="Usuario" class="form-control" placeholder="Nombre del usuario">
                                <input type="password" id="Contrasena_Actual" name="Contrasena_Actual" class="form-control" placeholder="Contraseña actual">
                                <input type="password" id="Contrasena_Nueva" name="Contrasena_Nueva" class="form-control" placeholder="Contraseña nueva">
                                <input type="password" id="Repite_Contrasena" name="Repite_Contrasena" class="form-control" placeholder="Repite la contraseña">
                                <button type="submit" class="btn_Guardar btn btn-primary mi-boton" id="btn_Guardar">GUARDAR</button>
                            </div>
                        </form>
                    </div>

                    <div class="Actualizar_Precios">
                        <form action="../Configuracion/CostoCita.php" method="POST">
                            <h4 class="display-6 fw-bold lh-1 fs-6">ACTUALIZAR PRECIOS DE CONSULTAS</h4>
                            <?php
                            require '../Configuracion/CostoCita.php';
                            echo '<label for="Individual">Precio de Cita Individual</label>';
                            echo '<input type="text" class="form-control" id="Individual" name="Individual" value="' . $costoIndividual . '">';
                            echo '<label for="Infantil">Precio de Cita Infantil</label>';
                            echo '<input type="text"class="form-control" id="Infantil" name="Infantil" value="' . $costoInfantil . '">';
                            echo '<label for="Adolescente">Precio de Cita Adolescente</label>';
                            echo '<input type="text"class="form-control" id="Adolescente" name="Adolescente" value="' . $costoAdolescente . '">';
                            ?>
                            <input type="submit" class="btn btn-primary mi-boton" name="actualizar_precio" value="ACTUALIZAR">
                        </form>
                    </div>
                </div>

                <div class="col">
                    <div class="Dias_Nolaborables">
                        <form action="../Configuracion/ModificarFechas.php" method="POST" id="formDiasNoLaborables">
                            <h4 class="display-6 fw-bold lh-1 fs-6">SELECCIONE LOS DÍAS NO LABORALES</h4>
                            <table class="table table-responsive table-bordered border-dark table-hover text-center text-capitalize">
                                <tr class="table-dark table-active text-upperacase">
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
                            <div id="contenedorFechas"></div>
                            <button type="button" class="botonAceptar btn btn-primary mi-boton" id="botonAceptar">ACEPTAR</button>
                            <input type="submit" class="btn btn-primary mi-boton" name="accion_cancelar" value="CANCELAR FECHA">
                            <button type="button" class="btn btn-primary mi-boton" id="btnAgregarFecha">AGREGAR FECHA</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            if (params.has('error')) {
                const error = params.get('error');
                let message = '';
                switch (error) {
                    case 'Nombre_usuario_existente':
                        message = 'El nombre de usuario ya está en uso.';
                        break;
                    case 'Contraseña_incorrecta':
                        message = 'No se realizo ningun cambio';
                        break;
                    case 'Contraseñas_no_coinciden':
                        message = 'Las contraseñas nuevas no coinciden.';
                        break;
                    case 'Error_Actualizar_Dia_No_Laborable':
                        message = 'Error al actualizar el día no laborable.';
                        break;
                    case 'Error_Actualizar_Dia':
                        message = 'Error al actualizar el día.';
                        break;
                    case 'Error_Actualizar_Precio':
                        message = 'Error al actualizar el precio de la cita.';
                        break;
                    case 'Seleccione_Dia':
                        message = 'Seleccione el dia que desea eliminar';
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
                    case 'Nombre_usuario_actualizado':
                        message = 'El nombre de usuario ha sido actualizado correctamente.';
                        break;
                    case 'Contraseña_actualizada':
                        message = 'La contraseña ha sido actualizada correctamente.';
                        break;
                    case 'Dia_No_Laborable_Actualizado':
                        message = 'El día no laborable ha sido actualizado correctamente.';
                        break;
                    case 'Dias_Actualizados':
                        message = 'La fecha ha sido cancelada correctamente';
                        break;
                    case 'Precio_actualizado':
                        message = 'El precio de la cita ha sido actualizado correctamente.';
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

    <script src="../JS/menulateral.js"></script>
    <script src="../JS/ConfiguracionPsicologo.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>

</html>
