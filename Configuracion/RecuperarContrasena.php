<?php
include_once('Conexion_BD.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Usuario = $_POST['Usuario'];
    $Correo = $_POST['Correo'];
    $Pregunta1 = $_POST['Pregunta1'];
    $Respuesta1 = $_POST['Respuesta1'];
    $Pregunta2 = $_POST['Pregunta2'];
    $Respuesta2 = $_POST['Respuesta2'];
    $NuevaContrasena = $_POST['Contrasena_Nueva'];
    $RepetirContrasena = $_POST['Repite_Contrasena'];

    // Verificar que NuevaContraseña y RepetirContraseña coincidan
    if ($NuevaContrasena !== $RepetirContrasena) {
        header("Location: ../PHP/Recuperar_Contrasena.php?error=Contraseñas_No_Coinciden");
        exit();
    }
    // Primera consulta para verificar el usuario
    $ConsultaUsuario = "SELECT Id_Usuario, Usuario FROM usuario WHERE Usuario =?";
    $SentenciaUsuario = $Conexion->prepare($ConsultaUsuario);
    $SentenciaUsuario->bind_param("s", $Usuario);
    $SentenciaUsuario->execute();

    $resultadoUsuario = $SentenciaUsuario->get_result();
    if ($resultadoUsuario->num_rows > 0) {
        $row = $resultadoUsuario->fetch_assoc();
        $Id_Usuario = $row['Id_Usuario'];

        // Segunda consulta para verificar el correo y las respuestas de seguridad
        $ConsultaDatos = "SELECT Id_Usuario, Correo, Pregunta1, Respuesta1, Pregunta2, Respuesta2 FROM datos_usuario WHERE Id_Usuario =? AND Correo =? AND Pregunta1 =? AND Respuesta1 =? AND Pregunta2 =? AND Respuesta2 =?";
        $SentenciaDatos = $Conexion->prepare($ConsultaDatos);
        $SentenciaDatos->bind_param("ssssss", $Id_Usuario, $Correo, $Pregunta1, $Respuesta1, $Pregunta2, $Respuesta2); // "s" significa string
        $SentenciaDatos->execute();

        $resultadoDatos = $SentenciaDatos->get_result(); // Obtener el objeto de resultado
        if ($resultadoDatos->num_rows > 0) {
            $NuevaContrasena = md5($NuevaContrasena);

            $ConsultaActualizacion = "UPDATE usuario SET Contrasena =? WHERE Id_Usuario =?";
            $SentenciaActualizacion = $Conexion->prepare($ConsultaActualizacion);
            $SentenciaActualizacion->bind_param("si", $NuevaContrasena, $Id_Usuario); // "i" significa integer
            $SentenciaActualizacion->execute();

            if ($SentenciaActualizacion->affected_rows > 0) {
                header("Location:../PHP/Iniciar_Sesion.php?sucess=Contraseñas_Actualizada");
                exit();
            } else {
                header("Location:../PHP/Recuperar_Contrasena.php?error=Error_en_Actualizacion");
                exit();
            }
        } else {
            header("Location: ../PHP/Recuperar_Contrasena.php?error=Datos_de_Seguridad_No_Coinciden");
            exit();
        }
    } else {
        header("Location: ../PHP/Recuperar_Contrasena.php?error=Usuario_no_Existe");
        exit();
    }
}
