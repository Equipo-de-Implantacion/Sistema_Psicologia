<?php
session_start();
include_once('../Configuracion/Conexion_BD.php');
include('../Configuracion/CargarDireccion.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location:../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

$Consulta = "SELECT Id_TipoUsuario FROM usuario WHERE Id_Usuario = '" . $_SESSION['Id_Usuario'] . "'";
$Resultado = $Conexion->query($Consulta);
$Fila = $Resultado->fetch_assoc();

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
    <!-- Final del menu  -->';

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
        
        ';
} else {
    $menuLateral = '';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emoción Vital</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/menulateral.css">
    <link href="../CSS/Agendar_Cita.css" rel="stylesheet">
    <!-- Enlazar hoja de estilos CSS -->
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">



</head>

<body>

<div class="Menu_Lateral" id="Menu_Lateral">
        <?php echo $menuLateral; ?>
    </div>

    <main>



        <div class="card d-flex align-items-center justify-content-center vh-100">
            <div class="container">

                <div class="Nombre_Usuario">
                        <?php
                    if (isset($_SESSION['Usuario'])) {
                        echo "Bienvenido, " . $_SESSION['Usuario'];
                    }
                    ?>
                </div>
                    
                

                <nav class="Pasos_cita lh-1 fs-5">
                    <ul id="Pasos">
                        <li class="paso">1<div class="linea"></div>
                        </li>
                        <li class="paso">2<div class="linea"></div>
                        </li>
                        <li class="paso">3<div class="linea"></div>
                        </li>
                        <li class="paso">4</li>
                    </ul>
                </nav>

                <form id="Formulario_Cita" action="../Configuracion/AgendarCita.php" method="POST">
               
           
                    <!-- SELECCION DE TIPO DE CITA -->
                    <section id="Tipo_Cita" class="Seccion activa">

                        <h2 class="display-6 fw-bold lh-1">SELECCIONE EL TIPO DE CITA</h2>
                        <img src="../Imagenes/lOGO PSICOLOGIA FULL BLANCO.png" alt="Imagen" class="imagen-selector"> <!-- Agrega la imagen aquí -->


                        <br>
                        <div class="dropdown">
                            <button class="Selector" id="selectorButton">SELECCIONE UN SERVICIO</button>
                            <div class="dropdown-content">
                                <a href="#" data-value="1">Psicoterapia Individual</a>
                                <a href="#" data-value="3">Psicoterapia Infantil</a>
                                <a href="#" data-value="4">Psicoterapia para Adolescentes</a>
                            </div>
                            <input type="hidden" id="Servicio" name="Servicio" required>
                        </div>


                        <h2 class="fw-bold duraciontext">
                            CADA SERVICIO TIENE UNA DUREACIÓN DE 45 MINUTOS.
                        </h2>
                    </section>


                    <!-- SELECCION DE FECHA Y HORA -->
                    <section id="Fecha_Hora" class="Seccion">

                        <h3 class="display-6 fw-bold lh-1">SELECCIONE FECHA Y HORA DE CITA</h2>
                            <br>
                            <section class="fechas">
                                <h5 class="display-15 fw-bold ">SELECCIONE FECHA
                        </h3>

                        <input type="date" name="Fecha" id="Fecha" required>

                    </section>
                    <br>
                    <section class="horas">

                        <h5 class="display-10 fw-bold ">SELECCIONE HORA</h3>
                            <input type="time" name="Hora" id="Hora" required>
                    </section>

                    </section>
                    <!-- SELECCION DE FECHA Y HORA -->



                    <!-- DATOS DE PACIENTE -->
                    <section id="Datos_Paciente" class="Seccion">
                        <h2>Información de Paciente</h2>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <!-- Columna 1 -->
                                <div class="mb-3">
                                    <label for="Tipo_Documento">Tipo de Documento</label>
                                    <select name="Tipo_Documento" id="Tipo_Documento" class="form-select" required>
                                        <option value="" disabled selected>Tipo de Documento</option>
                                        <option value="V-">Venezolano</option>
                                        <option value="J-">Jurídico</option>
                                        <option value="E-">Extranjero</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <input type="text" name="Documento_Id" class="form-control"
                                        placeholder="Documento de Identidad" required>
                                </div>

                                <!--CAMPO DE CITA INFANTIL O ADOLESCENTE-->
                                <div class="Datos_Menor" id="Datos_Menor">
                                    <div class="mb-3 d-flex align-items-center">
                                        <label for="Tiene_Documento" class="mr-2">¿Posee documento de
                                            identificación?</label>
                                        <input type="checkbox" id="Tiene_Documento" name="Tiene_Documento"
                                            onchange="mostrarDocumento()">
                                    </div>


                                    <div id="Documento_Menor_Div" style="display: none;">
                                        <div class="mb-3">
                                            <label for="Tipo_Documento_Menor">Tipo de Documento del Menor</label>
                                            <select name="Tipo_Documento_Menor" id="Tipo_Documento_Menor"
                                                class="form-select">
                                                <option value="" disabled selected>Tipo de Documento del Menor</option>
                                                <option value="V-">Venezolano</option>
                                                <option value="J-">Jurídico</option>
                                                <option value="E-">Extranjero</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <input type="text" name="Documento_Menor" class="form-control"
                                                placeholder="Documento de Identidad">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <input type="text" name="Parentezco" id="Parentezco" class="form-control"
                                            placeholder="Parentezco">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <input type="text" name="Primer_Nombre" id="Primer_Nombre" class="form-control"
                                        placeholder="Primer Nombre" required>
                                </div>

                                <div class="mb-3">
                                    <input type="text" name="Segundo_Nombre" id="Segundo_Nombre" class="form-control"
                                        placeholder="Segundo Nombre">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Columna 2 -->
                                <div class="mb-3">
                                    <input type="text" name="Primer_Apellido" id="Primer_Apellido" class="form-control"
                                        placeholder="Primer Apellido" required>
                                </div>

                                <div class="mb-3">
                                    <input type="text" name="Segundo_Apellido" id="Segundo_Apellido"
                                        class="form-control" placeholder="Segundo Apellido">
                                </div>

                                <div class="mb-3">
                                    <label for="Fecha_Nacimiento">Fecha de Nacimiento</label>
                                    <input type="date" name="Fecha_Nacimiento" id="Fecha_Nacimiento"
                                        class="form-control" placeholder="Fecha de Nacimiento" required>
                                </div>

                                <div class="mb-3">
                                    <input type="text" name="Telefono" id="Telefono" class="form-control"
                                        placeholder="Teléfono" required>
                                </div>

                                <div class="mb-3">
                                    <input type="email" name="Correo" id="Correo" class="form-control"
                                        placeholder="Correo Electrónico" required>
                                </div>

                                <div class="mb-3">
                                    <label for="Sexo">Sexo</label>
                                    <select name="Sexo" id="Sexo" class="form-select" required>
                                        <option value="" disabled selected>Seleccione sexo</option>
                                        <option value="Femenino">Femenino</option>
                                        <option value="Masculino">Masculino</option>
                                    </select>
                                </div>

                                <!--CAMPO DE CITA INDIVIDUAL O PAREJA-->
                                <div class="Datos_Mayor" id="Datos_Mayor">
                                    <div class="mb-3">
                                        <input type="text" name="Profesion" id="Profesion" class="form-control"
                                            placeholder="Profesión">
                                    </div>

                                    <div class="mb-3">
                                        <input type="text" name="Num_Hijos" id="Num_Hijos" class="form-control"
                                            placeholder="Cantidad de hijos">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Columna 3 -->
                                <h5>DIRECCIÓN</h5>
                                <div class="mb-3">
                                    <select id="Estado" name="Estado" class="form-select" required>
                                        <option value="" disabled selected>Seleccione Estado</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <select id="Municipio" name="Municipio" class="form-select" required>
                                        <option value="" disabled selected>Seleccione Municipio</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <select id="Parroquia" name="Parroquia" class="form-select" required>
                                        <option value="" disabled selected>Seleccione Parroquia</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <select id="Ciudad" name="Ciudad" class="form-select" required>
                                        <option value=" " disabled selected>Seleccione Ciudad </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <input type="text" name="Direccion_Vivienda" id="Direccion_Vivienda"
                                        class="form-control" placeholder="Dirección de vivienda" required>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- CONFIRMAR CITA -->
                    <section id="Confirmar_Cita" class="Seccion">
                        <div class="contenedorconfirmar">

                           
                        <h2 class="display-6 fw-bold lh-1">¿DESEA CONFIRMAR SU CITA?</h2>

                        <br>
                        <br>

                        <h7>Psicóloga:</h7>

                        <b>Licenciada Daniela Mogollón<b>
                            <button type=" button" id="cancelarBtn"
                                class="btn btn-primary mi-boton me-3">CANCELAR</button>
                        </div>
                    </section>

                    <div class="d-flex justify-content-center">


                    <button type="submit" class="btn_Confirmar btn btn-primary mi-boton me-3"  id="btn_Confirmar">CONFIRMAR</button>
                    </div>

                </form>

                <div class="d-flex justify-content-center">

                    <button type="button" class="btn btn-primary mi-boton me-3"
                        onclick="AnteriorPaso()">ANTERIOR</button>
                    <button type="button" class="btn btn-primary mi-boton me-3" id="btn_Siguiente"
                        onclick="SiguientePaso()">SIGUIENTE</button>
                </div>
            </div>
        </div>

    </main>


    <script>


    </script>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
        
    <script src="../JS/menulateral.js"></script>
    <script src="../JS/CargarDireccion.js"></script>
    <script src="../JS/AgendarCita.js"></script>
    <script src="../JS/CargarDireccion.js"></script>
    <script src="../JS/Validaciones.js"></script>
    <script src="../JS/ValidarFecha.js"></script>
    <script src="../JS/ValidarHora.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
                    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        document.querySelector('#btn_Confirmar').addEventListener('click', () => {
            localStorage.setItem('showConfirmationToast', 'true');
        });

        window.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('showConfirmationToast') === 'true') {
                toastr.success('¡Tu cita se realizó correctamente!', 'Mensaje de confirmación', {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
                localStorage.removeItem('showConfirmationToast');
            }
        });
    </script>


</body>

</html>