<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once('Conexion_BD.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

$Id_TipoUsuario = $_SESSION['Id_TipoUsuario'];

if (isset($_POST['seleccionar'])) {
    foreach ($_POST['seleccionar'] as $Fila) {
        $datos = explode("|", $Fila);
        if (count($datos) == 4) {
            $idPaciente = $datos[0];
            $idCita = $datos[1];
            $idCalendario = $datos[2];
            $tipoCita = $datos[3];
        }
    }
}

// Acción para Modificar Cita
if (isset($_POST['accion_modificar'])) {
    if (isset($_POST['seleccionar']) && count($_POST['seleccionar']) > 1) {
        // Redirige a Citas_Agendadas si Id_TipoUsuario es 1
        if ($Id_TipoUsuario == 1) {
            header("Location:../PHP/Citas_Agendadas.php?error=Mas_de_dos_citas");
            exit();
        }
        // Redirige a Citas_Psicologo si Id_TipoUsuario es 2
        elseif ($Id_TipoUsuario == 2) {
            header("Location:../PHP/Citas_Psicologo.php?error=Mas_de_dos_citas");
            exit();
        }
    } elseif (isset($_POST['seleccionar']) && count($_POST['seleccionar']) > 0) {
        header("Location: VisualizarCita.php?idPaciente=" . $idPaciente . "&idCita=" . $idCita . "&idCalendario=" . $idCalendario . "&tipoCita=" . $tipoCita);
        exit();
    } else {
        if ($Id_TipoUsuario == 1) {
            header("Location:../PHP/Citas_Agendadas.php?error=Seleccione_Cita");
            exit();
        } elseif ($Id_TipoUsuario == 2) {
            header("Location:../PHP/Citas_Psicologo.php?error=Seleccione_Cita");
            exit();
        }
    }
}

// Acción para eliminar de forma lógica la cita
if (isset($_POST['accion_eliminar'])) {
    if (empty($idPaciente) || empty($idCita) || empty($idCalendario)) {
        if ($Id_TipoUsuario == 1) {
            header("Location:../PHP/Citas_Agendadas.php?error=No_Seleccionado");
            exit();
        } elseif ($Id_TipoUsuario == 2) {
            header("Location:../PHP/Citas_Psicologo.php?error=No_Seleccionado");
            exit();
        }
    }

    try {
        // Estado del paciente
        $ConsultaPac = "UPDATE paciente SET Status = 'Inactivo' WHERE Id_Paciente = ?";
        $Declaracion1 = $Conexion->prepare($ConsultaPac);
        $Declaracion1->bind_param("i", $idPaciente);
        $Declaracion1->execute();

        // Estado de la cita
        $ConsultaCit = "UPDATE cita SET Status_Cita = 'Suspendido', Status = 'Cancelado' WHERE Id_Cita = ?";
        $Declaracion2 = $Conexion->prepare($ConsultaCit);
        $Declaracion2->bind_param("i", $idCita);
        $Declaracion2->execute();

        // Estado del calendario
        $ConsultaCal = "UPDATE calendario SET Status = 'Inactivo' WHERE Id_Calendario = ?";
        $Declaracion3 = $Conexion->prepare($ConsultaCal);
        $Declaracion3->bind_param("i", $idCalendario);
        $Declaracion3->execute();

        if ($Id_TipoUsuario == 1) {
            header("Location:../PHP/Citas_Agendadas.php?success=Cita_Eliminada");
            exit();
        } elseif ($Id_TipoUsuario == 2) {
            header("Location:../PHP/Citas_Psicologo.php?success=Cita_Eliminada");
            exit();
        }
    } catch (Exception $e) {
        if ($Id_TipoUsuario == 1) {
            header("Location:../PHP/Citas_Agendadas.php?error=Error_al_eliminar_Cita");
            exit();
        } elseif ($Id_TipoUsuario == 2) {
            header("Location:../PHP/Citas_Psicologo.php?error=Error_al_eliminar_Cita");
            exit();
        }
    }
}

// Acción para Aceptar Cita
if (isset($_POST['accion_aceptar'])) {

    // Verificar si hay alguna cita seleccionada
    if (isset($_POST['seleccionar']) && count($_POST['seleccionar']) > 0) {
        // Preparar y ejecutar la consulta para actualizar el estado de la cita
        foreach ($_POST['seleccionar'] as $Fila) {
            $datos = explode("|", $Fila);
            if (count($datos) == 4) {
                $idCita = $datos[1];

                // Consulta para actualizar el estado de la cita
                $ConsultaActualizarCita = "UPDATE cita SET Status_Cita = 'Agendada', Status = 'Aprobado' WHERE Id_Cita =?";
                $DeclaracionActualizarCita = $Conexion->prepare($ConsultaActualizarCita);
                $DeclaracionActualizarCita->bind_param("i", $idCita);
                $DeclaracionActualizarCita->execute();
            }
        }

        header("Location: ../PHP/Menu_Psicologo.php?success=Cita_Aceptada");
    } else {
        header("Location:../PHP/Menu_Psicologo.php?error=Seleccione_Cita");
        exit();
    }
}


// Acción para Cancelar Cita
if (isset($_POST['accion_cancelar'])) {
    if (isset($_POST['seleccionar']) && count($_POST['seleccionar']) > 0) {
        foreach ($_POST['seleccionar'] as $Fila) {
            $datos = explode("|", $Fila);
            if (count($datos) == 4) {
                $idCita = $datos[1];

                // Consulta para actualizar el estado de la cita
                $ConsultaActualizarCita = "UPDATE cita SET Status_Cita = 'Suspendido', Status = 'Cancelado' WHERE Id_Cita =?";
                $DeclaracionActualizarCita = $Conexion->prepare($ConsultaActualizarCita);
                $DeclaracionActualizarCita->bind_param("i", $idCita);
                $DeclaracionActualizarCita->execute();
            }
        }

        // Actualizar el estado del calendario
        $ConsultaActualizarCalendario = "UPDATE calendario SET Status = 'Inactivo' WHERE Id_Calendario =?";
        $DeclaracionActualizarCalendario = $Conexion->prepare($ConsultaActualizarCalendario);
        $DeclaracionActualizarCalendario->bind_param("i", $idCalendario);
        $DeclaracionActualizarCalendario->execute();

        header("Location: ../PHP/Menu_Psicologo.php?success=Cita_Cancelada");
    } else {
        header("Location:../PHP/Menu_Psicologo.php?error=Seleccione_Cita");
        exit();
    }
}
