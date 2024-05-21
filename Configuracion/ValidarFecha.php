<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once('Conexion_BD.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location:../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

$ConsultaDia = "SELECT Dia FROM nolaborable";
$DeclaracionDia = $Conexion->prepare($ConsultaDia);
if ($DeclaracionDia->execute() === false) {
    header("Location:../PHP/Error.php?error=Error_Consulta_Dia");
    exit();
}
$DeclaracionDia = $DeclaracionDia->get_result();

$dias = [];

while ($Fila = $DeclaracionDia->fetch_assoc()) {
    $dias[] = $Fila['Dia'];
}

$DeclaracionDia->close();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fechaSeleccionada = $_POST['fecha'];
    $fechaFormateada = date('Y-m-d', strtotime($fechaSeleccionada));
    // Verificar si la fecha coincide con alguna de las fechas no laborables
    $coincide = false;
    foreach ($dias as $dia) {
        if ($fechaFormateada == $dia) {
            $coincide = true;
            break;
        }
    }

    if ($coincide) {
        $respuesta = json_encode(['mensaje' => 'Fecha no laborable']);
    } else {
        $respuesta = json_encode(['mensaje' => 'Fecha recibida']);
    }
    // Enviar la respuesta al cliente
    echo $respuesta;
} else {
    $respuesta = json_encode(['error' => 'Método de solicitud no permitido']);
    echo $respuesta;
}
