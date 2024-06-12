<?php
session_start();

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

include('Conexion_BD.php');
include('CargarDireccion.php');



$Id_Usuario = $_SESSION['Id_Usuario'];

if (isset($_POST['Estado'], $_POST['Municipio'], $_POST['Parroquia'], $_POST['Ciudad'], $_POST['Direccion_Vivienda'], $_POST['Servicio'], $_POST['Fecha'], $_POST['Hora'], $_POST['Tipo_Documento'], $_POST['Documento_Id'], $_POST['Primer_Nombre'], $_POST['Segundo_Nombre'], $_POST['Primer_Apellido'], $_POST['Segundo_Apellido'], $_POST['Fecha_Nacimiento'], $_POST['Telefono'], $_POST['Correo'], $_POST['Sexo'])) {

    function validar($dato)
    {
        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato);
        return $dato;
    }


    $idEstado = validar($_POST['Estado']);
    $idMunicipio = validar($_POST['Municipio']);
    $idParroquia = validar($_POST['Parroquia']);
    $idCiudad = validar($_POST['Ciudad']);
    $Direccion_Vivienda = validar($_POST['Direccion_Vivienda']);
    $Servicio = validar($_POST['Servicio']);
    $Hora = validar($_POST['Hora']);
    $Fecha = validar($_POST['Fecha']);
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
    $Status = "Activo";

    if ($Telefono <= 0 || $Documento_Id <= 0) {
        header("Location: ../PHP/Agendar_Cita.php?error=valor_invalido");
        exit();
    }

    try {
        // Verificación de campos vacíos
        if (empty($idEstado) || empty($idMunicipio) || empty($idParroquia) || empty($idCiudad) || empty($Direccion_Vivienda) || empty($Servicio) || empty($Fecha) || empty($Hora) || empty($Tipo_Documento) || empty($Documento_Id) || empty($Primer_Nombre) || empty($Primer_Apellido) || empty($Fecha_Nacimiento) || empty($Telefono) || empty($Correo) || empty($Sexo)) {
            header("Location: ../PHP/Agendar_Cita.php?error=Datos_Vacíos");
            exit();
        }

        // Procesamiento de la dirección
        if ($idEstado && $idMunicipio && $idParroquia && $idCiudad && $Direccion_Vivienda) {
            $ConsultaDir = $Conexion->prepare("INSERT INTO direccion (id_estado, id_municipio, id_parroquia, id_ciudad, Direccion_Vivienda) VALUES (?, ?, ?, ?, ?)");
            $ConsultaDir->bind_param("iiiis", $idEstado, $idMunicipio, $idParroquia, $idCiudad, $Direccion_Vivienda);
            $ConsultaDir->execute();
            $idDireccion = $ConsultaDir->insert_id;
        }

        // Procesamiento de la información del paciente mayor de edad
        if ($Servicio == 1) {
            $Profesion = validar($_POST['Profesion']);
            $Num_Hijos = validar($_POST['Num_Hijos']);

            $ConsultaInd = $Conexion->prepare("INSERT INTO paciente (Id_Usuario, Id_Cita, Tipo_Documento, Documento_Id, Primer_Nombre, Segundo_Nombre, Primer_Apellido, Segundo_Apellido, Fecha_Nacimiento, Telefono, Correo, Sexo, Profesion, Num_Hijos, Id_Direccion, Fecha_Registro, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
            $ConsultaInd->bind_param("iisssssssssssiis", $Id_Usuario, $Servicio, $Tipo_Documento, $Documento_Id, $Primer_Nombre, $Segundo_Nombre, $Primer_Apellido, $Segundo_Apellido, $Fecha_Nacimiento, $Telefono, $Correo, $Sexo, $Profesion, $Num_Hijos, $idDireccion, $Status);
            $ConsultaInd->execute();
            $Id_Paciente = $ConsultaInd->insert_id;

            // Procesamiento de la información del paciente menor de edad
        } else if ($Servicio == 3 || $Servicio == 4) {
            $Parentezco = validar($_POST['Parentezco']);
            $Tipo_Documento_Menor = empty($_POST['Tipo_Documento_Menor']) ? '' : validar($_POST['Tipo_Documento_Menor']);
            $Documento_Menor = empty($_POST['Documento_Menor']) ? '' : validar($_POST['Documento_Menor']);

            if (empty($Tipo_Documento_Menor) && empty($Documento_Menor)) {
                $Documento_Id .= '-1';
            }

            $ConsultaMenor = $Conexion->prepare("INSERT INTO paciente_menoredad (Id_Usuario, Id_Cita, Parentezco, Tipo_Documento, Documento_Id, Tipo_Documento_Menor, Documento_Menor, Primer_Nombre, Segundo_Nombre, Primer_Apellido, Segundo_Apellido, Fecha_Nacimiento, Telefono, Correo, Sexo, Id_Direccion, Fecha_Registro, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
            $ConsultaMenor->bind_param("iisssssssssssssis", $Id_Usuario, $Servicio, $Parentezco, $Tipo_Documento, $Documento_Id, $Tipo_Documento_Menor, $Documento_Menor, $Primer_Nombre, $Segundo_Nombre, $Primer_Apellido, $Segundo_Apellido, $Fecha_Nacimiento, $Telefono, $Correo, $Sexo, $idDireccion, $Status);
            $ConsultaMenor->execute();
            $Id_PacienteMenor = $ConsultaMenor->insert_id;
        }

        // Procesamiento de la cita y  horario
        $Hora_Inicio = $Hora;
        $HoraInicioObj = new DateTime($Hora_Inicio);
        $HoraFinObj = date_add($HoraInicioObj, new DateInterval('PT45M'));
        $Hora_Fin = $HoraFinObj->format('H:i:s');

        $Id_Paciente = isset($Id_Paciente) ? $Id_Paciente : NULL;
        $Id_PacienteMenor = isset($Id_PacienteMenor) ? $Id_PacienteMenor : NULL;
        $Id_Empleado = 1;
        $Status_Cita = 'Espera';
        $Status_Ct = 'Espera';

        $ConsultaCita = $Conexion->prepare("INSERT INTO cita (Hora_Inicio, Hora_Fin, Id_Paciente, Id_PacienteMenor, Id_Empleado, Status_Cita, Status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $ConsultaCita->bind_param("ssiiiss", $Hora_Inicio, $Hora_Fin, $Id_Paciente, $Id_PacienteMenor, $Id_Empleado, $Status_Cita, $Status_Ct);
        $ConsultaCita->execute();
        $Id_Cita = $ConsultaCita->insert_id;

        $Status_Cl = "Activo";
        $ConsultaFecha = $Conexion->prepare("INSERT INTO calendario (Id_Cita, Dia, Status) VALUES (?, ?, ?)");
        $ConsultaFecha->bind_param("iss", $Id_Cita, $Fecha, $Status_Cl);
        $ConsultaFecha->execute();

        header("Location: ../PHP/Agendar_Cita.php?sucess=Cita_Agendada_Exitosamente");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
