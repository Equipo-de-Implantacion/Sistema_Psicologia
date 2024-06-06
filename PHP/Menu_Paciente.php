<?php
session_start();
include_once('../Configuracion/Conexion_BD.php');
// Incluir archivo de configuración para cargar direcciones
include('../Configuracion/CargarDireccion.php');

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>

    <link rel="icon" href="imagenes/favicon-16x16.png" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/menucontenido.css">
    <link rel="stylesheet" href="../CSS/menulateral.css">


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

    <div class="principal p-3">
        <div class="contenido">

            <!-- Mostrar el nombre del usuario en la esquina superior -->
        <div class="Nombre_Usuario ">
                    <?php
                        if (isset($_SESSION['Usuario'])) {
                            echo "Bienvenido, " . $_SESSION['Usuario'];
                        }
                      ?>
        </div>

            
            <img src="../imagenes/lOGO PSICOLOGIA FULL BLANCO.png" alt="Logo" class="mi-logo">


            <p class="display-7 fw-bold lh-1 fs-5">PASOS PARA AGENDAR TU CITA</p>
            <button class="btn btn-primary mi-boton" onclick="window.location.href='../PHP/Agendar_Cita.php'">AGENDA TU
                CITA</button>


            <div class="row row-cols-1 row-cols-md-4 g-2">
                <div class="col">
                    <div class="card d-flex flex-column justify-content-center w-100">

                        <h1 class="title text-center"></h1>
                        <img src="../Imagenes/consulta3d.png" class="mx-auto d-block imagen">

                        <div class="card-body">

                            <p class="card-text text-center">Seleccione la consulta.</p>


                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card d-flex flex-column justify-content-center w-100">

                        <h1 class="title text-center"> </h1>
                        <img src="../Imagenes/informacion3d.png" class="mx-auto d-block imagen">

                        <div class="card-body">
                            <p class="card-text text-center">Ingrese sus datos.</p>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card d-flex flex-column justify-content-center w-100">

                        <h1 class="title  text-center"></h1>
                        <img src="../Imagenes/calendario3d.png" class="mx-auto d-block imagen">

                        <div class="card-body">
                            <p class="card-text text-center">Seleccione horario.</p>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card d-flex flex-column justify-content-center w-100">

                        <h1 class="title  text-center"></h1>
                        <img src="../Imagenes/verificacion3d.png" class="mx-auto d-block imagen">

                        <div class="card-body">
                            <p class="card-text text-center">Confirma tu cita.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        if (params.has('success')) {
            const success = params.get('success');
            if (success === 'registro_exitoso') {
                toastr.success('¡Registro exitoso!', 'Éxito', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: '5000'
                });
            }
        }
    });
</script>               


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="../JS/menulateral.js"></script>

    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
                    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</body>

</html>

