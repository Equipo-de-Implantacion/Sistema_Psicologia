<?php
session_start();
include_once('Conexion_BD.php');

$fechaSeleccionada = $_POST['fecha'];
$horaSeleccionada = $_POST['hora'];

// Formatear la fecha seleccionada 
$fechaFormateada = date('Y-m-d', strtotime($fechaSeleccionada));

$ConsultaHora = "SELECT Hora_Inicio, Hora_Fin, Dia FROM horasseleccionadas WHERE Dia =?";
$DeclaracionHora = $Conexion->prepare($ConsultaHora);
$DeclaracionHora->bind_param("s", $fechaFormateada); 
$DeclaracionHora->execute();
$resultado = $DeclaracionHora->get_result();

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $horaInicio = $fila['Hora_Inicio'];
    $horaFin = $fila['Hora_Fin'];

    // Verificar si la hora seleccionada está dentro del rango
    if (strtotime($horaSeleccionada) >= strtotime($horaInicio) && strtotime($horaSeleccionada) <= strtotime($horaFin)) {
        echo json_encode(['estado' => 'ocupada']);
    } else {
        echo json_encode(['estado' => 'disponible']);
    }
} else {
    echo json_encode(['estado' => 'no encontrado']);
}
?>
