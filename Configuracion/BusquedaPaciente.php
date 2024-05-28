<?php
session_start();
include_once('Conexion_BD.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location:../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

$Identificacion = filter_var($_POST['Identificacion']);


// Consulta a la tabla paciente
$ConsultaP = "SELECT Id_Paciente, Tipo_Documento, Documento_Id, Primer_Nombre, Segundo_Nombre, Primer_Apellido, Segundo_Apellido, 
              CONCAT(Tipo_Documento, ' ', Documento_Id) AS Identificacion, 
              CONCAT(Primer_Nombre, ' ', Segundo_Nombre) AS Nombre_Completo, 
              CONCAT(Primer_Apellido, ' ', Segundo_Apellido) AS Apellido_Completo, 
              Fecha_Nacimiento, Telefono, Id_Direccion 
              FROM paciente 
              WHERE Documento_Id =?";
$SentenciaP = $Conexion->prepare($ConsultaP);
$SentenciaP->bind_param("s", $Identificacion);

if ($SentenciaP->execute()) {
    $resultadoP = $SentenciaP->get_result();
    $datosPaciente = array();

    while ($fila = $resultadoP->fetch_assoc()) {
        $Id_Direccion = $fila['Id_Direccion'];
        $datosPaciente[] = [
            'Id_Paciente' => $fila['Id_Paciente'],
            'Identificacion' => $fila['Identificacion'],
            'Nombre' => $fila['Nombre_Completo'],
            'Apellido' => $fila['Apellido_Completo']
        ];
    }


    // Consulta a la tabla paciente_menoredad
    $ConsultaM = "SELECT Id_Paciente, Tipo_Documento, Documento_Id, Primer_Nombre, Segundo_Nombre, Primer_Apellido, Segundo_Apellido,
                 CONCAT(Tipo_Documento, ' ', Documento_Id) AS Identificacion,
                 CONCAT(Primer_Nombre, ' ', Segundo_Nombre) AS Nombre_Completo,
                 CONCAT(Primer_Apellido, ' ', Segundo_Apellido) AS Apellido_Completo,
                 Fecha_Nacimiento, Telefono, Id_Direccion
                 FROM paciente_menoredad
                 WHERE Documento_Id =?";
    $SentenciaM = $Conexion->prepare($ConsultaM);
    $SentenciaM->bind_param("s", $Identificacion);

    if ($SentenciaM->execute()) {
        $resultadoM = $SentenciaM->get_result();
        $datosMenoriedad = array();

        while ($fila = $resultadoM->fetch_assoc()) {
            $Id_Direccion = $fila['Id_Direccion'];
            $datosMenoriedad[] = [
                'Id_Paciente' => $fila['Id_Paciente'],
                'Identificacion' => $fila['Identificacion'],
                'Nombre' => $fila['Nombre_Completo'],
                'Apellido' => $fila['Apellido_Completo']
            ];
        }

        // Almacenar los datos en variables de sesión
        $_SESSION['datos_paciente'] = $datosPaciente;
        $_SESSION['datos_menoriedad'] = $datosMenoriedad;


        header("Location:../PHP/Historial_Clinico.php");
        exit();
    } else {
        header("Location:../PHP/Historial_Clinico.php?error=Error_Consulta");
        exit();
    }
} else {
    header("Location:../PHP/Historial_Clinico.php?error=Error_Consulta");
    exit();
}
