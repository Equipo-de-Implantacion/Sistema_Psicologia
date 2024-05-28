<?php
session_start();
include_once('../Configuracion/Conexion_BD.php');
include('../Configuracion/CargarDireccion.php');

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
</head>

<body>

    <!-- Mostrar el nombre del usuario -->
    <div class="Nombre_Usuario">
        <?php
        if (isset($_SESSION['Usuario'])) {
            echo "Bienvenido, " . $_SESSION['Usuario'];
        }
        ?>
    </div>

    <div class="Menu_Lateral" id="Menu_Lateral">
        <img src="" alt="">
        <ul>
            <li><a href="Menu_Psicologo.php">Inicio</a></li>
            <li><a href="Agendar_Cita.php">Agendar Cita</a></li>
            <li><a href="Citas_Psicologo.php">Citas Agendadas</a></li>
            <li><a href="Historial_Clinico.php">Historial Clinico</a></li>
            <li><a href="Nuevo_Registro.php">Registrar Usuario</a></li>
            <li><a href="Configuracion_Psicologo.php">Configuración</a></li>
            <li><a href="CerrarSesion.php">Cerrar Sesión</a></li>
        </ul>
    </div>


    <main>
        <form action="../Configuracion/NuevoRegistro.php" method="POST">
            <h2>Datos de Usuario</h2>

            <label for="Tipo_Usuario">Seleccione el tipo de usuario</label>
            <select name="Tipo_Usuario" id="Tipo_Usuario" required>
                <option value="" disabled selected>Selecciona el tipo de usuario</option>
                <option value="1">Paciente</option>
                <option value="2">Psicologo</option>
            </select>

            <label for="Usuario">Nombre de Usuario</label>
            <input type="text" id="Usuario" name="Usuario" placeholder="Usuario" required>

            <label for="Contrasena">Contraseña</label>
            <input type="password" id="Contrasena" name="Contrasena" placeholder="Contraseña" required>

            <label for="RContrasena">Repetir Contraseña</label>
            <input type="password" id="RContrasena" name="RContrasena" placeholder="Repetir Contraseña" required>

            <div class="Formulario_Psicologo">

                <h2>Información del Psicólogo</h2>
                <label for="Tipo_Documento">Tipo de Documento</label>
                <select name="Tipo_Documento" id="Tipo_Documento">
                    <option value="" disabled selected>Tipo de Documento</option>
                    <option value="V-">Venezolano</option>
                    <option value="J-">Jurídico</option>
                    <option value="E-">Extranjero</option>
                </select>

                <label for="Documento_Id">Documento de Identidad</label>
                <input type="text" name="Documento_Id" placeholder="Documento de Identidad" oninput="soloNumerosGuionesYPuntos(this)">

                <label for="Primer_Nombre">Primer Nombre</label>
                <input type="text" name="Primer_Nombre" id="Primer_Nombre" placeholder="Primer Nombre" oninput="soloLetras(this)">

                <label for="Segundo_Nombre">Segundo Nombre</label>
                <input type="text" name="Segundo_Nombre" id="Segundo_Nombre" placeholder="Segundo Nombre" oninput="soloLetras(this)">

                <label for="Primer_Apellido">Primer Apellido</label>
                <input type="text" name="Primer_Apellido" id="Primer_Apellido" placeholder="Primer Apellido" oninput="soloLetras(this)">

                <label for="Segundo_Apellido">Segundo Apellido</label>
                <input type="text" name="Segundo_Apellido" id="Segundo_Apellido" placeholder="Segundo Apellido" oninput="soloLetras(this)">

                <label for="Fecha_Nacimiento">Fecha de Nacimiento</label>
                <input type="date" name="Fecha_Nacimiento" id="Fecha_Nacimiento" placeholder="Fecha de Nacimiento">

                <label for="Telefono">Número de Teléfono</label>
                <input type="text" name="Telefono" id="Telefono" placeholder="Número de Teléfono" oninput="validarTelefono(this)">

                <label for="Correo">Correo Electrónico</label>
                <input type="email" name="Correo" id="Correo" onblur="validarCorreo(this)">

                <label for="Sexo">Sexo</label>
                <select name="Sexo" id="Sexo">
                    <option value="" disabled selected>Seleccione sexo</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Otro">Otro</option>
                </select>

                <label for="Profesion">Profesion</label>
                <input type="text" name="Profesion" id="Profesion" oninput="soloLetras(this)">

                <label for="Especialidad">Especialidad</label>
                <input type="text" name="Especialidad" id="Especialidad" oninput="soloLetras(this)">

                <h3>Dirección</h3>

                <label for="Estado">Estado</label>
                <select id="Estado" name="Estado">
                    <option value="" disabled selected>Seleccione Estado</option>

                </select>

                <label for="Municipio">Municipio</label>
                <select id="Municipio" name="Municipio">
                    <option value="" disabled selected>Seleccione Municipio</option>
                </select>


                <label for="Parroquia">Parroquia</label>
                <select id="Parroquia" name="Parroquia">
                    <option value="" disabled selected>Seleccione Parroquia</option>
                </select>


                <label for="Ciudad">Ciudad</label>
                <select id="Ciudad" name="Ciudad">
                    <option value=" " disabled selected>Seleccione Ciudad </option>
                </select>

                <label for="Direccion_Vivienda">Dirección de vivienda</label>
                <input type="text" name="Direccion_Vivienda" id="Direccion_Vivienda">

            </div>

            <button type="submit">Registrar</button>

        </form>
    </main>
    </div>
    <script src="../JS/Validaciones.js"></script>
    <script src="../JS/CargarDireccion.js"></script>
    <script src="../JS/NuevoRegistro.js"></script>
</body>

</html>
