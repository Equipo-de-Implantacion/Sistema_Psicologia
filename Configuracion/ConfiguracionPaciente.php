<?php
session_start();

include_once('Conexion_BD.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

$Id_Usuario = $_SESSION['Id_Usuario'];

//Obtener datos del usuario que inicia sesión
$Consulta = "SELECT Usuario, Contrasena FROM usuario WHERE Id_Usuario = ?";
$stmt = $Conexion->prepare($Consulta);
$stmt->bind_param("i", $Id_Usuario);
$stmt->execute();

$Usuario = $stmt->get_result()->fetch_assoc();

if (isset($_POST['eliminarCuenta'])) {
    // Cambiar el estado del usuario a inactivo
    $consultaEliminar = "UPDATE usuario SET Status_Usuario = 'Inactivo' WHERE Id_Usuario = ?";
    $sentenciaEliminar = $Conexion->prepare($consultaEliminar);
    $sentenciaEliminar->bind_param("i", $Id_Usuario);

    if ($sentenciaEliminar->execute()) {
        header("Location: ../PHP/Iniciar_Sesion.php?error=Cuenta_eliminada");
        exit();
    } else {
        header("Location: ../PHP/Iniciar_Sesion.php?error=Error_eliminar_cuenta");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Id_Usuario = $_SESSION['Id_Usuario'];
    $UsuarioActual = $_POST['Usuario'];
    $ContrasenaActual = $_POST['Contrasena_Actual'];
    $ContrasenaNueva = $_POST['Contrasena_Nueva'];
    $RepiteContrasena = $_POST['Repite_Contrasena'];

    // Verificar si el nuevo nombre de usuario ya existe
    if (!empty($UsuarioActual)) {
        $consultaUsuario = "SELECT COUNT(*) FROM usuario WHERE Usuario = ? AND Id_Usuario != ?";
        $sentenciaUsuario = $Conexion->prepare($consultaUsuario);
        $sentenciaUsuario->bind_param("si", $UsuarioActual, $Id_Usuario);
        $sentenciaUsuario->execute();
        $resultadoUsuario = $sentenciaUsuario->get_result()->fetch_row();

        if ($resultadoUsuario[0] == 0) {
            $ActualizarUsuario = "UPDATE usuario SET Usuario = ? WHERE Id_Usuario = ?";
            $ActualizarUsuario = $Conexion->prepare($ActualizarUsuario);
            $ActualizarUsuario->bind_param("si", $UsuarioActual, $Id_Usuario);
            $ActualizarUsuario->execute();

            header("Location: ../PHP/Configuracion_Paciente.php?success=Nombre_usuario_actualizado");
            exit();
        } else {
            header("Location: ../PHP/Configuracion_Paciente.php?error=Nombre_usuario_existente");
            exit();
        }
    }

    // Verificar si la contraseña actual coincide con la almacenada en la base de datos
    if (!empty($ContrasenaActual) && md5($ContrasenaActual, $Usuario['Contrasena'])) {

        if (!empty($ContrasenaNueva) && $ContrasenaNueva == $RepiteContrasena) {

            $Cambiar_Contrasena  = md5($ContrasenaNueva);
            $ActualizarContrasena = "UPDATE usuario SET Contrasena = ? WHERE Id_Usuario = ?";
            $sentenciaActualizar = $Conexion->prepare($ActualizarContrasena);
            $sentenciaActualizar->bind_param("si", $Cambiar_Contrasena, $Id_Usuario);
            $sentenciaActualizar->execute();

            header("Location: ../PHP/Configuracion_Paciente.php?success=Contraseña_actualizada");
            exit();
        } else {
            header("Location: ../PHP/Configuracion_Paciente.php?error=Contraseñas_no_coinciden");
            exit();
        }
    } else {
        header("Location: ../PHP/Configuracion_Paciente.php?error=Contraseña_incorrecta");
        exit();
    }
}
