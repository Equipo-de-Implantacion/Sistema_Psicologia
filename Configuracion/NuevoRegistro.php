<?php
session_start();

include_once('Conexion_BD.php');

if (!$Conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

if (isset($_POST['Tipo_Usuario']) && isset($_POST['Usuario']) && isset($_POST['Contrasena']) && isset($_POST['RContrasena'])) {

    function validar($dato)
    {
        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato);

        return $dato;
    }

    $Tipo_Usuario = validar($_POST['Tipo_Usuario']);
    $Usuario = validar($_POST['Usuario']);
    $Contrasena = validar($_POST['Contrasena']);
    $RContrasena = validar($_POST['RContrasena']);

    $datosUsuario = 'Usuario=' . $Usuario;

    if (empty($Usuario) ||  empty($Contrasena) || empty($RContrasena)) {
        header("Location: ../PHP/Nuevo_Registro.php?error=campos_vacios");
        exit();
    } else if ($Contrasena !== $RContrasena) {
        header("Location: ../PHP/Nuevo_Registro.php?error=contrasenas_no_coinciden&$datosUsuario");
        exit();
    } else {
        $Contrasena = md5($Contrasena);

        $ConsultaExistencia = "SELECT Usuario FROM usuario WHERE Usuario = '$Usuario'";
        $ResultadoExistencia = $Conexion->query($ConsultaExistencia);

        if (mysqli_num_rows($ResultadoExistencia) > 0) {
            header("Location: ../PHP/Nuevo_Registro.php?error=usuario_existente");
            exit();
        } else {
            $ConsultaRegistro = "INSERT INTO usuario (Id_TipoUsuario, Usuario, Contrasena, Status_Usuario, Fecha_Registro) VALUES ('$Tipo_Usuario', '$Usuario', '$Contrasena', 'Activo', NOW())";
            $ResultadoRegistro  = $Conexion->query($ConsultaRegistro);

            if ($ResultadoRegistro) {
                header("Location: ../PHP/Nuevo_Registro.php?success=registro_exitoso");
                exit();
            } else {
                header("Location: ../PHP/Nuevo_Registro.php?error=error_registro");
                exit();
            }
        }
    }
} else {
    header("Location: ../PHP/Nuevo_Registro.php");
    exit();
}
