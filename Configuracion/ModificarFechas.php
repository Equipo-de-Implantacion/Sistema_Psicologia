<?php
session_start();
include_once('../Configuracion/Conexion_BD.php');

// Recibir los datos del formulario
$fechasRecibidas = $_POST['nuevaFecha'];

foreach ($fechasRecibidas as $fecha) {
    // Convertir la fecha recibida a formato yyyy/mm/dd
    $fechaFormateada = date('Y/m/d', strtotime($fecha));
    
    // Aquí puedes procesar cada fecha recibida
    // Por ejemplo, guardarlas en la base de datos o realizar alguna otra acción
    echo "Fecha recibida: $fechaFormateada<br>";
}
?>
