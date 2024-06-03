<?php
session_start();

include_once('Conexion_BD.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

if (isset($_POST['Tipo_Usuario']) && isset($_POST['Usuario']) && isset($_POST['Contrasena']) && isset($_POST['RContrasena']) && isset($_POST['Tipo_Usuario'])) {

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
            $resultadoRegistro = $Conexion->query($ConsultaRegistro);

            if ($resultadoRegistro) {
                $Id_Usuario = $Conexion->insert_id;
                if ($Tipo_Usuario == 2) {
                    $Tipo_Documento = validar($_POST['Tipo_Documento']);
                    $Documento_Id = validar($_POST['Documento_Id']);
                    $Primer_Nombre = validar($_POST['Primer_Nombre']);
                    $Segundo_Nombre = empty($_POST['Segundo_Nombre']) ? '' : validar($_POST['Segundo_Nombre']);
                    $Primer_Apellido = validar($_POST['Primer_Apellido']);
                    $Segundo_Apellido = empty($_POST['Segundo_Apellido']) ? '' : validar($_POST['Segundo_Apellido']);
                    $Fecha_Nacimiento = validar($_POST['Fecha_Nacimiento']);
                    $Telefono = validar($_POST['Telefono']);
                    $Correo = validar($_POST['Correo']);
                    $Sexo = validar($_POST['Sexo']);
                    $Profesion = validar($_POST['Profesion']);
                    $Especialidad = validar($_POST['Especialidad']);


                    $idEstado = validar($_POST['Estado']);
                    $idMunicipio = validar($_POST['Municipio']);
                    $idParroquia = validar($_POST['Parroquia']);
                    $idCiudad = validar($_POST['Ciudad']);
                    $Direccion_Vivienda = validar($_POST['Direccion_Vivienda']);

                    $ConsultaDir = $Conexion->prepare("INSERT INTO direccion (id_estado, id_municipio, id_parroquia, id_ciudad, Direccion_Vivienda) VALUES (?, ?, ?, ?, ?)");
                    $ConsultaDir->bind_param("iiisi", $idEstado, $idMunicipio, $idParroquia, $idCiudad, $Direccion_Vivienda);
                    $ConsultaDir->execute();
                    $idDireccion = $ConsultaDir->insert_id;

                    $ConsultaEmpleado = $Conexion->prepare("INSERT INTO empleado (Id_Usuario, Tipo_Documento, Documento_Id, Primer_Nombre, Segundo_Nombre, Primer_Apellido, Segundo_Apellido, Fecha_Nacimiento, Telefono, Correo, Sexo, Id_Direccion, Profesion, Especialidad, Fecha_Registro, Status_Empleado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),'Activo')");
                    $ConsultaEmpleado->bind_param("issssssssssiss", $Id_Usuario, $Tipo_Documento, $Documento_Id, $Primer_Nombre, $Segundo_Nombre, $Primer_Apellido, $Segundo_Apellido, $Fecha_Nacimiento, $Telefono, $Correo, $Sexo, $idDireccion, $Profesion, $Especialidad);
                    $ConsultaEmpleado->execute();

                    header("Location: ../PHP/Nuevo_Registro.php?sucess=Registro_Exitoso");
                }
            }
            header("Location: ../PHP/Nuevo_Registro.php?sucess=Registro_Exitoso");
        }
    }
} else {
    header("Location: ../PHP/Nuevo_Registro.php?error=Error_Registro");
    exit();
}
