<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emoción Vital</title>
</head>

<body>

    <div class="Contenedor_Principal">
        <div class="Contenedor_Texto">
            <h2>¿TIENES CUENTA? </h2>
            <P>Inicia sesión aquí</P>
            <a href="Iniciar_Sesion.php">INICIAR SESIÓN</a>
        </div>

        <main>
            <form action="../Configuracion/RecuperarContrasena.php" method="POST">
                <h2>Datos de Usuario</h2>
                <label for="Usuario">Usuario</label>
                <input type="text" id="Usuario" name="Usuario" placeholder="Usuario" required>

                <label for="Correo">Correo Electrónico</label>
                <input type="email" id="Correo" name="Correo" placeholder="Correo" required>

                <h2>Preguntas de Seguridad</h2>
                <p>Debes seleccionar tus preguntas de seguridad para reestablecer tu cuenta</p>

                <label for="Pregunta1">Primera Pregunta</label>
                <select name="Pregunta1" id="Pregunta1" required>
                    <option value="" disabled selected>Selecciona tu primera pregunta</option>
                    <option value="Madre">¿Nombre de su madre?</option>
                    <option value="Padre">¿Nombre de su padre?</option>
                    <option value="Mascota">¿Nombre de su mascota?</option>
                    <option value="Color">¿Color preferido?</option>
                </select>

                <input type="text" id="Respuesta1" name="Respuesta1" placeholder="Respuesta" required>

                <label for="Pregunta2">Primera Pregunta</label>
                <select name="Pregunta2" id="Pregunta2" required>
                    <option value="" disabled selected>Selecciona tu segunda pregunta</option>
                    <option value="Ciudad">¿Ciudad preferida?</option>
                    <option value="Comida">¿Comida preferida?</option>
                    <option value="Lugar">¿Lugar preferido?</option>
                    <option value="Animal">¿Animal preferido?</option>
                </select>

                <input type="text" id="Respuesta2" name="Respuesta2" placeholder="Respuesta" required>

                <h2>Cambiar Contraseña</h2>
                <label for="Contrasena">Nueva Contraseña</label>
                <input type="password" id="Contrasena_Nueva" name="Contrasena_Nueva" placeholder="Contraseña Nueva" required>

                <label for="Repite_Contrasena">Repite tu nueva contraseña</label>
                <input type="password" id="Repite_Contrasena" name="Repite_Contrasena" placeholder="Repite Contraseña" required>

                <button type="submit">Aceptar</button>
            </form>
        </main>
    </div>

</body>

</html>