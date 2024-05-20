<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Emoción Vital</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <link href="../CSS/Iniciar_Sesion.css" rel="stylesheet">
</head>

<body>

  <div class="contenedor-principal">

    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
      <div class="container-fluid" style="max-height: 40vh;">

        <a class="navbar-brand" href="#">
          <img src="../Imagenes/Logo psicologia.png" alt="Logo" class="logo">
        </a>
        <!-- Botón de Hamburguesa para dispositivos móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Elementos del menú  -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../Principal.html">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Sobre mi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contacto</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="contenedorFoto">
      <div class="row justify-content-center">
        <div class="col-auto">
          <img src="../Imagenes/señor.png" class="img-fluid" alt="Tu imagen">
        </div>
      </div>
    </div>

    <div class="contenedor-texto">
      <h2>INICIA SESIÓN PARA <br> AGENDAR TU CITA</h2>
      <p>Si no tienes una cuenta regístrate aqui</p>
      <a href="Registrar_Usuario.php" alt="registrarboton" class="btn btn-primary">REGISTRARSE</a>
    </div>


    <!-- Formulario para Inicio de Sesión -->
    <main class="formulario">
      <form action="../Configuracion/InicioSesion.php" method="POST">
        <img src="../Imagenes/Psychology Logo.png" alt="Logo Encima" class="logo-encima">
        <label for="usuario"><strong>Usuario</strong></label>
        <input type="text" id="usuario" name="Usuario" class="form-control" required>
        <label for="contrasena"><strong>Contraseña</strong></label>
        <input type="password" id="contrasena" name="Contrasena" class="form-control" required>
        <button class="btn btn-primary w-100 py-2" type="Iniciar Sesion">INICIAR SESIÓN</button>
        <a href="Recuperar_Contrasena.php">¿Olvido su contraseña?</a>
      </form>
    </main>


    <!-- Bootstrap Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script src="../JS/MenuNavbar.js"></script>
</body>

</html>