<?php

if (!isset($_SESSION)) {
    session_start();
}

include_once('../Configuracion/Conexion_BD.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

$idPaciente = $_GET['idPaciente'];
$idCita = $_GET['idCita'];
$idCalendario = $_GET['idCalendario'];
$tipoCita = $_GET['tipoCita'];

$FechaFormateada = '';

if ($tipoCita == 'Individual') {
    //Obtener correo de paciente
    $ConsultaPaciente = "SELECT Correo FROM paciente WHERE Id_Paciente =?";
    $SentenciaPaciente = $Conexion->prepare($ConsultaPaciente);
    $SentenciaPaciente->bind_param("i", $idPaciente);
    $SentenciaPaciente->execute();
    $ResultadoPaciente = $SentenciaPaciente->get_result();

    if ($ResultadoPaciente->num_rows > 0) {
        $Fila = $ResultadoPaciente->fetch_assoc();
        $correoPaciente = $Fila['Correo'];
    } else {
        header("Location:../PHP/Menu_Psicologo.php?error=Error_al_obtener_correo");
        exit();
    }

    // Consulta para obtener la hora de inicio de la cita
    $ConsultaCita = "SELECT Hora_Inicio FROM cita WHERE Id_Cita =?";
    $SentenciaCita = $Conexion->prepare($ConsultaCita);
    $SentenciaCita->bind_param("i", $idCita);
    $SentenciaCita->execute();
    $ResultadoCita = $SentenciaCita->get_result();

    if ($ResultadoCita->num_rows > 0) {
        $FilaCita = $ResultadoCita->fetch_assoc();
        $horaInicio = $FilaCita['Hora_Inicio'];
    } else {
        header("Location:../PHP/Menu_Psicologo.php?error=Error_al_obtener_hora");
        exit();
    }

    // Consulta para obtener el día del calendario
    $ConsultaCalendario = "SELECT Dia FROM calendario WHERE Id_Calendario =?";
    $SentenciaCalendario = $Conexion->prepare($ConsultaCalendario);
    $SentenciaCalendario->bind_param("i", $idCalendario);
    $SentenciaCalendario->execute();
    $ResultadoCalendario = $SentenciaCalendario->get_result();

    if ($ResultadoCalendario->num_rows > 0) {
        $FilaCalendario = $ResultadoCalendario->fetch_assoc();
        $FechaOriginal = $FilaCalendario['Dia']; //Obtiene el día en formato yyyy-mm-dd

        $FechaObjeto = DateTime::createFromFormat('Y-m-d', $FechaOriginal);
        // Formatear la fecha al formato dd/mm/yyyy
        $FechaFormateada = $FechaObjeto->format('d/m/Y');
    } else {
        header("Location:../PHP/Menu_Psicologo.php?error=Error_al_obtener_Dia");
        exit();
    }
} elseif ($tipoCita == 'Infante' || $tipoCita == 'Adolescente') {
    //Obtiene correo del paciente
    $ConsultaPaciente = "SELECT Correo FROM paciente_menoredad WHERE Id_Paciente =?";
    $SentenciaPaciente = $Conexion->prepare($ConsultaPaciente);
    $SentenciaPaciente->bind_param("i", $idPaciente); // "i" indica que esperamos un entero como parámetro
    $SentenciaPaciente->execute();
    $ResultadoPaciente = $SentenciaPaciente->get_result();

    if ($ResultadoPaciente->num_rows > 0) {
        $Fila = $ResultadoPaciente->fetch_assoc();
        $correoPaciente = $Fila['Correo'];
    } else {
        header("Location:../PHP/Menu_Psicologo.php?error=Error_al_obtener_correo");
        exit();
    }

    // Consulta para obtener la hora de inicio de la cita
    $ConsultaCita = "SELECT Hora_Inicio FROM cita WHERE Id_Cita =?";
    $SentenciaCita = $Conexion->prepare($ConsultaCita);
    $SentenciaCita->bind_param("i", $idCita);
    $SentenciaCita->execute();
    $ResultadoCita = $SentenciaCita->get_result();

    if ($ResultadoCita->num_rows > 0) {
        $FilaCita = $ResultadoCita->fetch_assoc();
        $horaInicio = $FilaCita['Hora_Inicio'];
    } else {
        header("Location:../PHP/Menu_Psicologo.php?error=Error_al_obtener_hora");
        exit();
    }

    // Consulta para obtener el día del calendario
    $ConsultaCalendario = "SELECT Dia FROM calendario WHERE Id_Calendario =?";
    $SentenciaCalendario = $Conexion->prepare($ConsultaCalendario);
    $SentenciaCalendario->bind_param("i", $idCalendario);
    $SentenciaCalendario->execute();
    $ResultadoCalendario = $SentenciaCalendario->get_result();

    if ($ResultadoCalendario->num_rows > 0) {
        $FilaCalendario = $ResultadoCalendario->fetch_assoc();
        $FechaOriginal = $FilaCalendario['Dia'];

        $FechaObjeto = DateTime::createFromFormat('Y-m-d', $FechaOriginal);

        $FechaFormateada = $FechaObjeto->format('d/m/Y');
    } else {
        header("Location:../PHP/Menu_Psicologo.php?error=Error_al_obtener_Dia");
        exit();
    }
}

//Código para el envio de correo
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host       = 'SMTP.gmail.com';

    $mail->SMTPAuth   = true;
    $mail->Username   = 'psicologia.emocionvital@gmail.com';
    $mail->Password   = 'rxifqkbismjpnzmp';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    //Recipients
    $mail->setFrom('psicologia.emocionvital@gmail.com', 'EMOCION VITAL');
    $mail->addAddress($correoPaciente);
    $mail->addAddress('psicologia.emocionvital@gmail.com');

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'EMOCION VITAL: CONFIRMAMOS TU CITA';


    $bodyContent = '
        <h1>Confirmación de tu Cita Psicológica</h1>
        <p>Hola, gracias por programar tu consulta con nuestro equipo de EMOCIÓN VITAL.</p>
        <p>Tu cita ha sido confirmada para:</p>
        <ul>
        <li><strong>Fecha:</strong> ' . $FechaFormateada . '</li>
        <li><strong>Hora:</strong> ' . $horaInicio . '</li>
        </ul>
        <p>A continuación, te proporcionamos el enlace para acceder a nuestra reunión de Meet:</p>
        <p><a href="https://meet.google.com/wqn-rgcy-rfx">Acceder a la Reunión</a></p>
        <p>Por favor, asegúrate de estar en tiempo y forma para esta cita. Si necesitas cambiar la fecha o hora, no dudes en notificarnos lo antes posible.</p>
        <p>Atentamente,</p>
        <h3>Equipo de EMOCIÓN VITAL</h3>';

    $mail->Body = $bodyContent;

    $mail->send();
    header("Location: ../PHP/Menu_Psicologo.php?success=Cita_Aceptada");
    //echo 'El mensaje se envió correctamente';
} catch (Exception $e) {
    echo "Hubo un error al enviar el mensaje: {$mail->ErrorInfo}";
}
