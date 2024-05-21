<?php
session_start();
include_once('../Configuracion/Conexion_BD.php');

// Inicio Sesion de usuario
if (!isset($_SESSION['Id_Usuario'])) {
    header("Location:../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

$Id_Usuario = $_SESSION['Id_Usuario'];
$Id_TipoUsuario = $_SESSION['Id_TipoUsuario'];

// Primera consulta para verificar si el usuario ya tiene un registro
$stmt = $Conexion->prepare("SELECT Id_Usuario FROM datos_usuario WHERE Id_Usuario =?");
$stmt->bind_param("i", $Id_Usuario);
$stmt->execute();
$stmt->store_result();

// Segunda consulta para obtener el Id_TipoUsuario
if ($stmt->num_rows > 0) { // Solo intentamos obtener el Id_TipoUsuario si el usuario ya tiene un registro
    $stmt->close();

    // Preparar la segunda consulta para obtener el Id_TipoUsuario
    $stmt = $Conexion->prepare("SELECT Id_TipoUsuario FROM usuario WHERE Id_Usuario =?");
    $stmt->bind_param("i", $Id_Usuario);
    $stmt->execute();
    $stmt->store_result();

    // Obtener el Id_TipoUsuario
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($Id_TipoUsuario);
        $stmt->fetch();
    } else {
        header("Location: ../PHP/Iniciar_Sesion.php?error=no_se_encontro_usuario");
        exit();
    }

    // Redirigir según el Id_TipoUsuario
    if ($Id_TipoUsuario == 1) {
        header("Location: ../PHP/Menu_Paciente.php");
    } elseif ($Id_TipoUsuario == 2) {
        header("Location: ../PHP/Menu_Psicologo.php");
    }
} else {
    header("Location: ../PHP/Datos_Usuario.php");
    exit();
}

$stmt->close();
