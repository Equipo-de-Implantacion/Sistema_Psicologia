<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emoción Vital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/Olvidocontraseña.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">

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
              <i class="ri-account-pin-circle-fill"></i>
              <span>SABER MÁS</span>
            </a>
          </li>

          <li class="nav__item">
            <a href="https://www.instagram.com/emocion_vital/?utm_source=ig_web_button_share_sheet" class="nav__link">
              <i class="ri-instagram-fill"></i>
              <span>INSTAGRAM</span>
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



    <div class="Contenido_Principal ">


        <form action="../Configuracion/RecuperarContrasena.php" method="POST">

              
            <div class="text-center mb-4">

                <h1 class="display-6 fw-bold lh-1">RECUPERA TU CONTRASEÑA</h1>
                <button type="button" class="btn btn-primary mi-boton" onclick="window.location.href='Iniciar_Sesion.php'">INICIAR SESIÓN</button>
                <p>Si tienes una cuenta, Inicia sesión aquí</p>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h2 class="display-6 fw-bold lh-1 fs-6">DATOS DE USUARIO</h2>
                    <input type="text" id="Usuario" name="Usuario" class="form-control mb-3" placeholder="Usuario" required>

                    <input type="email" id="Correo" name="Correo" class="form-control mb-3" placeholder="Correo" required>

                    <h2 class="display-6 fw-bold lh-1 fs-6">CAMBIAR CONTRASEÑA</h2>
                    <input type="password" id="Contrasena_Nueva" name="Contrasena_Nueva" class="form-control mb-3" placeholder="Contraseña Nueva" required>

                    <input type="password" id="Repite_Contrasena" name="Repite_Contrasena" class="form-control mb-3" placeholder="Repite Contraseña" required>
               

                </div>

                <div class="col-md-6">
                    <h2 class="display-6 fw-bold lh-1 fs-6">PREGUNTAS DE SEGURIDAD</h2>

                    <select name="Pregunta1" id="Pregunta1" class="form-select mb-3" required>
                        <option value="" disabled selected>Selecciona tu primera pregunta</option>
                        <option value="Madre">¿Nombre de su madre?</option>
                        <option value="Padre">¿Nombre de su padre?</option>
                        <option value="Mascota">¿Nombre de su mascota?</option>
                        <option value="Color">¿Color preferido?</option>
                    </select>

                    <input type="text" id="Respuesta1" name="Respuesta1" class="form-control mb-3" placeholder="Respuesta" required>
                    <br>
                    <select name="Pregunta2" id="Pregunta2" class="form-select mb-3" required>
                        <option value="" disabled selected>Selecciona tu segunda pregunta</option>
                        <option value="Ciudad">¿Ciudad preferida?</option>
                        <option value="Comida">¿Comida preferida?</option>
                        <option value="Lugar">¿Lugar preferido?</option>
                        <option value="Animal">¿Animal preferido?</option>
                    </select>

                    <input type="text" id="Respuesta2" name="Respuesta2" class="form-control mb-3" placeholder="Respuesta" required>

                </div>

            </div>
            
            <button type="submit" class="btn btn-success btn-primary mi-boton">ACEPTAR</button>

        </form>

    

    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        if (params.has('error')) {
            const error = params.get('error');
            let message = '';
            switch (error) {
                case 'Contraseñas_No_Coinciden':
                    message = 'Las contraseñas no coinciden.';
                    break;
                case 'Error_en_Actualizacion':
                    message = 'Error al actualizar la contraseña.';
                    break;
                case 'Datos_de_Seguridad_No_Coinciden':
                    message = 'Los datos de seguridad no coinciden.';
                    break;
                case 'Usuario_no_Existe':
                    message = 'El usuario no existe.';
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
        } else if (params.has('success')) {
            const success = params.get('success');
            let message = '';
            switch (success) {
                case 'Contraseñas_Actualizada':
                    message = 'La contraseña ha sido actualizada correctamente.';
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="../JS/navbar.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>

</html>