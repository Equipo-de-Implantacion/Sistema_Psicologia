<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <link href="../CSS/Registrar_Usuario.css" rel="stylesheet">
</head>
<body>

<div class="contenedor-principal">

    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">

      <div class="container-fluid" style="max-height: 40vh;">

        <a class="navbar-brand" href="#">
          <img src="../Imagenes/logo blanco psicologia.png" alt="Logo" class="logo">
        </a>
        <!-- Botón de hamburguesa para dispositivos móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Elementos del menú -->
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


    <div class="contenedor-texto">
    <h3 class="titulo-registro">REGISTRATE 
        PARA <br> AGENDAR TU CITA</h3>
      <p>Si ya tienes una cuenta inicia sesión aqui</p>
      <a href="Iniciar_Sesion.php" alt="iniciarsesionboton" class="btn btn-primary">INICIAR SESIÓN</a>
    </div>


    <!-- Formulario para registrar un nuevo usuario -->
    <main class="formulario-registro">

    <form action="../Configuracion/RegistroUsuario.php" method="POST">
    <img src="../Imagenes/Psychology Logo blanco.png" alt="Logo Encima" class="logo-encima">
       
    <label for="usuario"><strong>Usuario</strong></label>
    <input type="text" id="usuario" name="Usuario" class="form-control">
    <label for="contrasena"><strong>Contraseña</strong></label>
    <input type="password" id="contrasena" name="Contrasena" class="form-control">
    <label for="rcontrasena"><strong>Repetir Contraseña</strong></label>
    <input type="password" id="rcontrasena" name="RContrasena" class="form-control">
    <button class="btn btn-primary w-100 py-2" type="submit">REGISTRARSE</button>
    </form>

    </main>


     <!-- Bootstrap Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

    <script src="../JS/MenuNavbar.js"></script>
   
    
</body>
</html>