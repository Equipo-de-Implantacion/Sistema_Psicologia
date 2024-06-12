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
    <link rel="icon" href="../imagenes/favicon-16x16.png" type="image/x-icon">

    <link href="../CSS/Obtener_Historial.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">


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



        <div class="Seleccione_Paciente">

                            <img src="../imagenes/lOGO PSICOLOGIA FULL BLANCO.png" alt="Logo" class="mi-logo">

                            <div class="titulos">
                                <h1 class="display-5 fw-bold lh-1">CREAR HISTORIAL</h1>
                                <div class="Nombre_Usuario">
                                    <?php
                                        if (isset($_SESSION['Usuario'])) {
                                        echo "Bienvenido, " . $_SESSION['Usuario'];
                                        }
                                    ?>
                                </div>
                    
                                <p>En esta sección  puede buscar un paciente</p>
                                
                            </div>

            <div class="buscador">                
                            <form id="BusquedaPaciente" action="../Configuracion/BusquedaPaciente.php" method="POST">
                                <button id="btn_Identificacion" class="btn btn-primary mi-boton" name="btn_Identificacion">BUSCAR PACIENTE</button>

                                <input type="text" class="form-control" id="Identificacion" name="Identificacion"  placeholder= "Ingrese la cédula del paciente">

                            </form>


                            <p>Pulsa sobre el paciente para crear</p>

                            <!-- Mostrar los resultados -->
                            <table  class="table table-responsive table-bordered border-dark table-hover text-center text-capitalize" id="resultadoTabla" >
                                <thead>
                                    <tr class="table-dark table-active text-upperacase">
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
        </div>

    </main>

            <script>
            document.addEventListener('DOMContentLoaded', () => {
                const params = new URLSearchParams(window.location.search);
                if (params.has('error')) {
                    const error = params.get('error');
                    let message = '';
                    switch (error) {
                        case 'Error_Consulta':
                            message = 'Error al consultar el historial clínico.';
                            break;
                            case 'Error_Historial_Clinico':
                        message = 'Error al realizar el historial clinico';
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
                    case 'Historial_Clinico_Exitoso':
                        message = '¡Historial realizado con exito!';
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
    <script src="../JS/SeccionPaciente.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
  


</body>

</html>
