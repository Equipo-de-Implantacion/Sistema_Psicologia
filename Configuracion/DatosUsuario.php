<?php
session_start();
include_once('Conexion_BD.php');

// Inicio Sesion de usuario
if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

// Verificar si Id_TipoUsuario está establecido en la sesión
if (!isset($_SESSION['Id_TipoUsuario'])) {
    header("Location:../PHP/Error.php?error=tipo_usuario_no_definido");
    exit();
}


if (isset($_POST['Tipo_Documento']) && isset($_POST['Documento_Id']) && isset($_POST['Primer_Nombre']) && isset($_POST['Segundo_Nombre']) && isset($_POST['Primer_Apellido']) && isset($_POST['Segundo_Apellido']) && isset($_POST['Fecha_Nacimiento']) && isset($_POST['Telefono']) && isset($_POST['Correo']) && isset($_POST['Sexo']) && isset($_POST['Pregunta1']) && isset($_POST['Respuesta1']) && isset($_POST['Pregunta2']) && isset($_POST['Respuesta2'])) {
    function validar($dato)
    {
        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato);
        return $dato;
    }

    $Tipo_Documento = validar($_POST['Tipo_Documento']);
    $Documento_Id = validar($_POST['Documento_Id']);
    $Primer_Nombre = validar($_POST['Primer_Nombre']);
    $Segundo_Nombre = validar($_POST['Segundo_Nombre']);
    $Primer_Apellido = validar($_POST['Primer_Apellido']);
    $Segundo_Apellido = validar($_POST['Segundo_Apellido']);
    $Fecha_Nacimiento = validar($_POST['Fecha_Nacimiento']);
    $Telefono = validar($_POST['Telefono']);
    $Correo = validar($_POST['Correo']);
    $Sexo = validar($_POST['Sexo']);
    $Pregunta1 = validar($_POST['Pregunta1']);
    $Respuesta1 = validar($_POST['Respuesta1']);
    $Pregunta2 = validar($_POST['Pregunta2']);
    $Respuesta2 = validar($_POST['Respuesta2']);

    // Validar que el teléfono y la cédula sean mayores que cero
    if ($Telefono <= 0 || $Documento_Id <= 0) {
        header("Location: ../PHP/Datos_Usuario.php?error=valor_invalido");
        exit();
    }

    // Validar que la fecha de nacimiento sea mayor a 18 años
    $fechaNacimiento = DateTime::createFromFormat('Y-m-d', $Fecha_Nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($fechaNacimiento)->y;

    if ($edad < 18) {
        header("Location: ../PHP/Datos_Usuario.php?error=menor_de_edad");
        exit();
    }


    if (empty($Segundo_Nombre) || empty($Segundo_Apellido)) {
        $Segundo_Nombre = "Vacío";
        $Segundo_Apellido = "Vacío";
    }

    if (empty($Tipo_Documento) ||  empty($Documento_Id) || empty($Primer_Nombre) || empty($Segundo_Nombre) || empty($Primer_Apellido) || empty($Segundo_Apellido) || empty($Fecha_Nacimiento) || empty($Telefono) || empty($Correo) || empty($Sexo) || empty($Pregunta1) || empty($Respuesta1) || empty($Pregunta2) || empty($Respuesta2)) {
        header("Location:../PHP/Datos_Usuario.php?error=campos_vacios");
        exit();
    } else {

        $Consulta1 = "SELECT Documento_Id FROM datos_usuario WHERE Documento_Id = '$Documento_Id'";
        $Resultado1 = $Conexion->query($Consulta1);

        if (mysqli_num_rows($Resultado1) > 0) {
            header("Location: ../PHP/Datos_Usuario.php?error=usuario_existente");
            exit();
        } else {

            $Id_Usuario = $_SESSION['Id_Usuario'];
            $Id_TpoUsuario = $_SESSION['Id_TipoUsuario'];

            $Consulta2 = "INSERT INTO datos_usuario (Id_Usuario, Tipo_Documento, Documento_Id, Primer_Nombre, Segundo_Nombre, Primer_Apellido, Segundo_Apellido, Fecha_Nacimiento, Telefono, Correo, Sexo, Pregunta1, Respuesta1, Pregunta2, Respuesta2, Fecha_Registro) VALUES ('$Id_Usuario', '$Tipo_Documento', '$Documento_Id', '$Primer_Nombre', '$Segundo_Nombre', '$Primer_Apellido', '$Segundo_Apellido', '$Fecha_Nacimiento', '$Telefono', '$Correo', '$Sexo', '$Pregunta1', '$Respuesta1', '$Pregunta2', '$Respuesta2', NOW())";
            $Resultado2 = $Conexion->query($Consulta2);

            if ($Resultado2) {
                if ($Id_TpoUsuario == 1) {
                    header("Location:../PHP/Menu_Paciente.php?success=registro_exitoso");
                } else if ($Id_TpoUsuario == 2) {
                    header("Location:../PHP/Menu_Psicologo.php?success=registro_exitoso");
                }
                exit();
            }
        }
    }
} else {
    header("Location: ../PHP/Datos_Usuario.php");
    exit();
}
