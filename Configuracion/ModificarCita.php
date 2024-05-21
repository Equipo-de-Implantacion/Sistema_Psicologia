<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once('Conexion_BD.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

$Id_Usuario = $_SESSION['Id_Usuario'];
$Id_TipoUsuario = $_SESSION['Id_TipoUsuario'];

if (isset($_POST['Estado'], $_POST['Municipio'], $_POST['Parroquia'], $_POST['Ciudad'], $_POST['Direccion_Vivienda'], $_POST['Servicio'], $_POST['Fecha'], $_POST['Hora'], $_POST['Tipo_Documento'], $_POST['Documento_Id'], $_POST['Primer_Nombre'], $_POST['Segundo_Nombre'], $_POST['Primer_Apellido'], $_POST['Segundo_Apellido'], $_POST['Fecha_Nacimiento'], $_POST['Telefono'], $_POST['Correo'], $_POST['Sexo'])) {

    function validar($dato)
    {
        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato);
        return $dato;
    }

    $idDireccion = intval($_POST['idDireccion']);
    $idPaciente = intval($_POST['idPaciente']);
    $idCita = intval($_POST['idCita']);
    $idEstado = validar($_POST['Estado']);
    $idMunicipio = validar($_POST['Municipio']);
    $idParroquia = validar($_POST['Parroquia']);
    $idCiudad = validar($_POST['Ciudad']);
    $Direccion_Vivienda = validar($_POST['Direccion_Vivienda']);
    $Servicio = validar($_POST['Servicio']);
    $Hora = validar($_POST['Hora']);
    $Fecha = validar($_POST['Fecha']);
    $Primer_Nombre = validar($_POST['Primer_Nombre']);
    $Segundo_Nombre = empty($_POST['Segundo_Nombre']) ? '' : validar($_POST['Segundo_Nombre']);
    $Primer_Apellido = validar($_POST['Primer_Apellido']);
    $Segundo_Apellido = empty($_POST['Segundo_Apellido']) ? '' : validar($_POST['Segundo_Apellido']);
    $Fecha_Nacimiento = validar($_POST['Fecha_Nacimiento']);
    $Telefono = validar($_POST['Telefono']);
    $Correo = validar($_POST['Correo']);
    $Sexo = validar($_POST['Sexo']);
    $Status = "Activo";

    // Verificación de campos vacíos
    if (empty($idEstado) || empty($idMunicipio) || empty($idParroquia) || empty($idCiudad) || empty($Direccion_Vivienda) || empty($Servicio) || empty($Fecha) || empty($Hora) || empty($Primer_Nombre) || empty($Primer_Apellido) || empty($Fecha_Nacimiento) || empty($Telefono) || empty($Correo) || empty($Sexo)) {
        header("Location: VisualizarCita.php?error=Datos_Vacíos");
        exit();
    }

    // Actualizar dirección
    if ($idEstado && $idMunicipio && $idParroquia && $idCiudad && $Direccion_Vivienda) {
        $ConsultaDir = "UPDATE direccion SET id_estado = ?, id_municipio = ?, id_parroquia = ?, id_ciudad = ?, Direccion_Vivienda = ? WHERE Id_Direccion = ?";
        $DeclaracionDir = $Conexion->prepare($ConsultaDir);
        $DeclaracionDir->bind_param("iiiisi", $idEstado, $idMunicipio, $idParroquia, $idCiudad, $Direccion_Vivienda, $idDireccion);
        $DeclaracionDir->execute();
    }

    // Actualizar la información del paciente mayor de edad
    if ($Servicio == 1) {
        $Profesion = validar($_POST['Profesion']);
        $Num_Hijos = validar($_POST['Num_Hijos']);

        $ConsultaInd = "UPDATE paciente SET Primer_Nombre = ?, Segundo_Nombre = ?, Primer_Apellido = ?, Segundo_Apellido = ?, Fecha_Nacimiento = ?, Telefono = ?, Correo = ?, Sexo = ?, Profesion = ?, Num_Hijos = ? WHERE Id_Paciente = ?";
        $DeclaracionInd  = $Conexion->prepare($ConsultaInd);
        $DeclaracionInd->bind_param("sssssssssii", $Primer_Nombre, $Segundo_Nombre, $Primer_Apellido, $Segundo_Apellido, $Fecha_Nacimiento, $Telefono, $Correo, $Sexo, $Profesion, $Num_Hijos, $idPaciente);
        $DeclaracionInd->execute();

        if (!$DeclaracionInd->execute()) {
            header("Location: VisualizarCita.php?error=error_actualizar_paciente_mayor");
            exit();
        }

        //Actualizar la información del paciente menor de edad
    } else if ($Servicio == 3 || $Servicio == 4) {
        $Parentezco = validar($_POST['Parentezco']);
        $Tipo_Documento_Menor = empty($_POST['Tipo_Documento_Menor']) ? '' : validar($_POST['Tipo_Documento_Menor']);
        $Documento_Menor = empty($_POST['Documento_Menor']) ? '' : validar($_POST['Documento_Menor']);

        if (empty($Tipo_Documento_Menor) && empty($Documento_Menor)) {
            $Documento_Id .= '-1';
        }
        $ConsultaMenor = "UPDATE paciente_menoredad SET Parentezco = ?, Primer_Nombre = ?, Segundo_Nombre = ?, Primer_Apellido = ?, Segundo_Apellido = ?, Fecha_Nacimiento = ?, Telefono = ?, Correo = ?, Sexo = ? WHERE Id_Paciente = ?";
        $DeclaracionMenor  = $Conexion->prepare($ConsultaMenor);
        $DeclaracionMenor->bind_param("sssssssssi", $Parentezco, $Primer_Nombre, $Segundo_Nombre, $Primer_Apellido, $Segundo_Apellido, $Fecha_Nacimiento, $Telefono, $Correo, $Sexo, $idPaciente);
        $DeclaracionMenor->execute();

        if (!$DeclaracionMenor->execute()) {
            header("Location: VisualizarCita.php?error=error_actualizar_paciente_menor");
            exit();
        }
    }

    // Procesamiento de la cita y horario
    $Hora_Inicio = $Hora;
    $HoraInicioObj = new DateTime($Hora_Inicio);
    $HoraFinObj = date_add($HoraInicioObj, new DateInterval('PT45M'));
    $Hora_Fin = $HoraFinObj->format('H:i:s');

    $Status_Cita = 'Espera';
    $Status = 'Espera';

    // Actualizar la cita
    $ConsultaCita = $Conexion->prepare("UPDATE cita SET Hora_Inicio = ?, Hora_Fin = ?, Status_Cita = ?, Status = ? WHERE Id_Cita = ?");
    $ConsultaCita->bind_param("ssssi", $Hora_Inicio, $Hora_Fin, $Status_Cita, $Status, $idCita);
    $ConsultaCita->execute();

    if (!$ConsultaCita->execute()) {
        header("Location: VisualizarCita.php?error=error_actualizar_cita");
        exit();
    }

    // Actualizar el calendario
    $ConsultaFecha = $Conexion->prepare("UPDATE calendario SET Dia = ? WHERE Id_Cita = ?");
    $ConsultaFecha->bind_param("si", $Fecha,  $idCita);
    $ConsultaFecha->execute();

    if (!$ConsultaCita->execute()) {
        header("Location: VisualizarCita.php?error=error_actualizar_cita");
        exit();
    }
    if ($Id_TipoUsuario == 1) {
        header("Location: ../PHP/Citas_Agendadas.php?sucess=Cita_Actualizada_Exitosamente");
    } else if ($Id_TipoUsuario == 2) {
        header("Location: ../PHP/Citas_Psicologo.php?sucess=Cita_Actualizada_Exitosamente");
    }
}
