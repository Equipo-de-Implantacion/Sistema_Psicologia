<?php

include_once('Conexion_BD.php');

if (isset($_POST['Usuario']) && isset($_POST['Contrasena']) && isset($_POST['RContrasena'])) {

    function validar($dato)
    {
        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato);

        return $dato;
    }

    $Usuario = validar($_POST['Usuario']);
    $Contrasena = validar($_POST['Contrasena']);
    $RContrasena = validar($_POST['RContrasena']);

    $datosUsuario = 'Usuario=' . $Usuario;

    if (empty($Usuario) ||  empty($Contrasena) || empty($RContrasena)) {
        header("Location: ../PHP/Registrar_Usuario.php?error=campos_vacios");
        exit();
    } else if ($Contrasena !== $RContrasena) {
        header("Location: ../PHP/Registrar_Usuario.php?error=contrasenas_no_coinciden&$datosUsuario");
        exit();
    } else {
        $Contrasena = md5($Contrasena);


        $Consulta1 = "SELECT Usuario FROM usuario WHERE Usuario = '$Usuario'";
        $Resultado1 = $Conexion->query($Consulta1 );

        if (mysqli_num_rows($Resultado1) > 0) {
            header("Location: ../PHP/Registrar_Usuario.php?error=usuario_existente");
            exit();
        } else {
            $Id_TipoUsuario = 1;


            $Consulta2 = "INSERT INTO usuario (Id_TipoUsuario, Usuario, Contrasena, Status_Usuario, Fecha_Registro) VALUES ('$Id_TipoUsuario', '$Usuario', '$Contrasena', 'Activo', NOW())";
            $Resultado2 = $Conexion->query($Consulta2);

            if ($Resultado2) {
                header("Location: ../PHP/Iniciar_Sesion.php?success=registro_exitoso");
                exit();
            } else {
                header("Location: ../PHP/Registrar_Usuario.php?error=error_registro");
                exit();
            }
        }
    }
} else {
    header("Location: ../PHP/Registrar_Usuario.php");
    exit();
}
