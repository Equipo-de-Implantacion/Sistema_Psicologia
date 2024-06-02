<?php
include_once('Conexion_BD.php');


$ConsultaDia = "SELECT Dia, DiaSemana FROM nolaborable";
$ResultadoDia = $Conexion->query($ConsultaDia);


$fechasRecibidas = isset($_POST['nuevaFecha']) ? $_POST['nuevaFecha'] : [];

foreach ($fechasRecibidas as $fecha) {
    $fechaFormateada = date('Y/m/d', strtotime($fecha));

    $ConsultaFecha = $Conexion->prepare("SELECT Dia, Status FROM diassemana WHERE Dia =?");
    $ConsultaFecha->bind_param("s", $fechaFormateada);
    $ConsultaFecha->execute();
    $ResultadoFecha = $ConsultaFecha->get_result()->fetch_all(MYSQLI_ASSOC);

    // Verificar si se encontró una fila
    if (!empty($ResultadoFecha)) {
        $consultaActualizar = $Conexion->prepare("UPDATE diassemana SET Status = 0 WHERE Dia =?");
        $consultaActualizar->bind_param("s", $fechaFormateada);
        if ($consultaActualizar->execute()) {
            header("Location: ../PHP/Configuracion_psicologo.php?success=Dia_No_Laborable_Actualizado");
            exit();
        } else {
            header("Location: ../PHP/Configuracion_Psicologo.php?error=Error_Actualizar_Dia_No_Laborable");
            exit();
        }
    }
}


if (isset($_POST['accion_cancelar'])) {
    if (isset($_POST['diaSeleccionado']) && count($_POST['diaSeleccionado']) > 0) {
        foreach ($_POST['diaSeleccionado'] as $diaSeleccionado) {
            $fechaFormateada = date('Y/m/d', strtotime($diaSeleccionado));

            $consultaActualizarDia = "UPDATE diassemana SET Status = 1 WHERE Dia =?";
            $declaracionActualizarDia = $Conexion->prepare($consultaActualizarDia);
            $declaracionActualizarDia->bind_param("s", $fechaFormateada);
            $declaracionActualizarDia->execute();
        }
        if ($declaracionActualizarDia->execute()) {
            header("Location:../PHP/Configuracion_Psicologo.php?success=Dias_Actualizados");
            exit();
        } else {
            header("Location:../PHP/Configuracion_Psicologo.php?error=Error_Actualizar_Dia");
            exit();
        }
    } else {
        header("Location:../PHP/Configuracion_Psicologo.php?error=Seleccione_Dia");
        exit();
    }
}
