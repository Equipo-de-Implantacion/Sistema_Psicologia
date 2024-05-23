<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Inicio de Sesión</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <link href="../CSS/Iniciar_Sesion.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


</head>
  <body>


   <!--==================== HEADER ====================-->
   <header class="header" id="header">
    <nav class="nav container">
      <a href="" class="nav__logo">
        <img class="logo" src="../Imagenes/LOGOFULLNEGRO.png" alt="Descripción del logo">

      </a>


      <div class="nav__menu" id="nav-menu">
        <ul class="nav__list">

          <li class="nav__item">
            <a href="../index.html" class="nav__link">
              <i class="ri-arrow-right-up-line"></i>
              <span>BLOG</span>
            </a>
          </li>

          <li class="nav__item">
            <a href="#" class="nav__link">
              <i class="ri-arrow-right-up-line"></i>
              <span>SOBRE MI</span>
            </a>
          </li>

          <li class="nav__item">
            <a href="#" class="nav__link">
              <i class="ri-arrow-right-up-line"></i>
              <span>CONTACTO</span>
            </a>
          </li>



          <!-- Close button -->
          <div class="nav__close" id="nav-close">
            <i class="ri-close-large-line"></i>
          </div>


      </div>

      <!-- Toggle button -->
      <div class="nav__toggle" id="nav-toggle">
        <i class="ri-menu-line"></i>
      </div>
    </nav>
  </header>




<div class="contenedor-principal">

<div class="contenedorFoto">
  <div class="row justify-content-center">
    <div class="col-auto">
      <img src="../Imagenes/señor.png" class="img-fluid" alt="Tu imagen">
    </div>
  </div>
</div>

    <div class="contenedor-texto" >
      <h2 class="display-7 fw-bold lh-1">INICIA SESIÓN PARA <br> AGENDAR TU CITA</h2>
      <p>Si no tienes una cuenta regístrate aqui</p>
      <button class="btn btn-primary mi-boton" alt="registrarboton" onclick="window.location.href='Registrar_Usuario.php'">REGISTRARSE</button>
    </div>


    <!-- Formulario para Inicio de Sesión -->
    <main class="formulario">
  <form action="../Configuracion/InicioSesion.php" method="POST">
    <label for="usuario"><strong>Usuario</strong></label>
    <input type="text" id="usuario" name="Usuario" class="form-control">
    <label for="contrasena"><strong>Contraseña</strong></label>
    <input type="password" id="contrasena" name="Contrasena" class="form-control">
    <button class="btn btn-primary mi-boton w-100 py-2" type="Iniciar Sesion">INICIAR SESIÓN</button>
    <a href="Recuperar_Contrasena.php">¿Olvido su contraseña?</a>
  </form>
</main>


    <!-- Bootstrap Bundle con Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

    <script src="../JS/navbar.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
                    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



    <!-- Toastr JS -->

<script src="../JS/navbar.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        if (params.has('success')) {
            const success = params.get('success');
            if (success === 'registro_exitoso') {
                toastr.success('¡Registro exitoso! Ahora puede iniciar sesión.', 'Éxito', {
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
        if (params.has('error')) {
            const error = params.get('error');
            let message = '';
            switch (error) {
                case 'campo_vacio':
                    message = 'Por favor, complete todos los campos.';
                    break;
                case 'contrasena_incorrecta':
                    message = 'Contraseña incorrecta. Intente nuevamente.';
                    break;
                case 'usuario_no_existe':
                    message = 'El usuario no existe. Verifique sus credenciales.';
                    break;
              
            }
            toastr.error(message, 'Error', {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000"
            });
        }
    });
</script>


</body>
</html>

