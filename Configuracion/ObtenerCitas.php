<?php
session_start();
include_once('../Configuracion/Conexion_BD.php');

$ConsultaMayor = "SELECT cl.Dia, ct.Hora_Inicio, ct.Hora_Fin, p.Id_Cita, p.Primer_Nombre, p.Primer_Apellido, tc.Tipo_Cita 
    FROM calendario AS cl INNER JOIN cita AS ct ON cl.Id_Cita = ct.Id_Cita INNER JOIN paciente AS p ON ct.Id_Paciente = p.Id_Paciente
    INNER JOIN tipo_cita AS tc ON p.Id_Cita = tc.Id_TipoCita WHERE ct.Status_Cita = 'Agendada' AND ct.Status = 'Aprobado' AND cl.Status = 'Activo' AND p.Status = 'Activo' ";

$ResultadoMayor = $Conexion->query($ConsultaMayor);

$ConsultaMenor = "SELECT cl.Dia, ct.Hora_Inicio, ct.Hora_Fin, pm.Id_Cita, pm.Primer_Nombre, pm.Primer_Apellido, tc.Tipo_Cita 
    FROM calendario AS cl INNER JOIN cita AS ct ON cl.Id_Cita = ct.Id_Cita INNER JOIN paciente_menoredad AS pm ON ct.Id_PacienteMenor = pm.Id_Paciente
    INNER JOIN tipo_cita AS tc ON pm.Id_Cita = tc.Id_TipoCita WHERE ct.Status_Cita = 'Agendada' AND ct.Status = 'Aprobado' AND cl.Status = 'Activo' AND pm.Status = 'Activo' ";

$ResultadoMenor = $Conexion->query($ConsultaMenor);

$eventsMayor = array();
$eventsMenor = array();

// Procesar eventos mayores
if ($ResultadoMayor->num_rows > 0) {
    while ($Fila = $ResultadoMayor->fetch_assoc()) {
        $inicioHoraMinuto = date('H:i', strtotime($Fila['Hora_Inicio']));
        $finHoraMinuto = date('H:i', strtotime($Fila['Hora_Fin']));

        $start = date('Y-m-d\TH:i:s', strtotime($Fila['Dia'] . ' ' . $inicioHoraMinuto));
        $end = date('Y-m-d\TH:i:s', strtotime($Fila['Dia'] . ' ' . $finHoraMinuto));

        $title = $Fila['Tipo_Cita'] . ' (' . $inicioHoraMinuto . ' - ' . $finHoraMinuto . ')';
        $event = array(
            'start' => $start,
            'end' => $end,
            'title' => $title,
        );
        $eventsMayor[] = $event;
    }
}

// Procesar eventos menores
if ($ResultadoMenor->num_rows > 0) {
    while ($Fila = $ResultadoMenor->fetch_assoc()) {
        $inicioHoraMinuto = date('H:i', strtotime($Fila['Hora_Inicio']));
        $finHoraMinuto = date('H:i', strtotime($Fila['Hora_Fin']));

        $start = date('Y-m-d\TH:i:s', strtotime($Fila['Dia'] . ' ' . $inicioHoraMinuto));
        $end = date('Y-m-d\TH:i:s', strtotime($Fila['Dia'] . ' ' . $finHoraMinuto));

        $title = $Fila['Tipo_Cita'] . ' (' . $inicioHoraMinuto . ' - ' . $finHoraMinuto . ')';
        $event = array(
            'start' => $start,
            'end' => $end,
            'title' => $title,
        );
        $eventsMenor[] = $event;
    }
}

// Decidir qué eventos mostrar basado en la existencia de eventos mayores y menores
if (count($eventsMayor) > 0 || count($eventsMenor) > 0) {
    $events = array_merge($eventsMayor, $eventsMenor);
} else {
    $events = array(); // No hay eventos, mostrar calendario vacío
}

header('Content-Type: application/json');
echo json_encode($events); // Envía el array combinado como respuesta JSON
$Conexion->close();
