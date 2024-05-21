<?php
include_once('Conexion_BD.php');


$idIndividual = 1;
$idInfantil = 3;
$idAdolescente = 4;

$costoIndividual = null;
$costoInfantil = null;
$costoAdolescente = null;

foreach ([$idIndividual, $idInfantil, $idAdolescente] as $idCita) {
    $ConsultaPrecio = "SELECT Costo FROM tipo_cita WHERE Id_TipoCita =?";
    $SentenciaPrecio = $Conexion->prepare($ConsultaPrecio);
    $SentenciaPrecio->bind_param("i", $idCita);
    $SentenciaPrecio->execute();
    $ResultadoPrecio = $SentenciaPrecio->get_result();

    if ($Fila = $ResultadoPrecio->fetch_assoc()) {
        switch ($idCita) {
            case $idIndividual:
                $costoIndividual = $Fila['Costo'];
                break;
            case $idInfantil:
                $costoInfantil = $Fila['Costo'];
                break;
            case $idAdolescente:
                $costoAdolescente = $Fila['Costo'];
                break;
        }
    }
}

if (isset($_POST['actualizar_precio'])) {
    try {
        $nuevoPrecioIndividual = $_POST['Individual'];
        $nuevoPrecioInfantil = $_POST['Infantil'];
        $nuevoPrecioAdolescente = $_POST['Adolescente'];

        $ActualizarIndividual = "UPDATE tipo_cita SET Costo=? WHERE Id_TipoCita=?";
        $SentenciaIndividual = $Conexion->prepare($ActualizarIndividual);
        $SentenciaIndividual->bind_param("di", $nuevoPrecioIndividual, $idIndividual);
        $SentenciaIndividual->execute();

        $ActualizarInfantil = "UPDATE tipo_cita SET Costo=? WHERE Id_TipoCita=?";
        $SentenciaInfantil = $Conexion->prepare($ActualizarInfantil);
        $SentenciaInfantil->bind_param("di", $nuevoPrecioInfantil, $idInfantil);
        $SentenciaInfantil->execute();

        $ActualizarAdolescente = "UPDATE tipo_cita SET Costo=? WHERE Id_TipoCita=?";
        $SentenciaAdolescente = $Conexion->prepare($ActualizarAdolescente);
        $SentenciaAdolescente->bind_param("di", $nuevoPrecioAdolescente, $idAdolescente);
        $SentenciaAdolescente->execute();

        // Redirigir o mostrar mensaje de éxito
        header("Location:../PHP/Configuracion_Psicologo.php?success=Precio_actualizado");
        exit;
    } catch (Exception $e) {
        echo "Error al actualizar el precio: " . $e->getMessage();
    }
}
