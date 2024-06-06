<?php
session_start();
include_once('../Configuracion/Conexion_BD.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location:../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

if (isset($_GET['Id_Paciente'])) {
    $Id_Paciente = $_GET['Id_Paciente'];

    $ConsultaP = "SELECT Id_Paciente, Tipo_Documento, Documento_Id, Primer_Nombre, Segundo_Nombre, Primer_Apellido, Segundo_Apellido,
     CONCAT(Tipo_Documento, ' ', Documento_Id) AS Identificacion,
     CONCAT(Primer_Nombre, ' ', Segundo_Nombre, ' ', Primer_Apellido, ' ', Segundo_Apellido) AS Nombre_Completo,
     Fecha_Nacimiento, Telefono, Id_Direccion 
     FROM paciente 
     WHERE Id_Paciente =?";
    $SentenciaP = $Conexion->prepare($ConsultaP);
    $SentenciaP->bind_param("i", $Id_Paciente);

    if ($SentenciaP->execute()) {
        $ResultadoP = $SentenciaP->get_result();

        // Verificar si hay resultados
        if ($ResultadoP->num_rows > 0) {
            $FilaP = $ResultadoP->fetch_assoc();

            $Id_Paciente = $FilaP['Id_Paciente'];
            $Tipo_Documento = $FilaP['Tipo_Documento'];
            $Documento_Id = $FilaP['Documento_Id'];
            $Primer_Nombre = $FilaP['Primer_Nombre'];
            $Segundo_Nombre = $FilaP['Segundo_Nombre'];
            $Primer_Apellido = $FilaP['Primer_Apellido'];
            $Segundo_Apellido = $FilaP['Segundo_Apellido'];
            $Fecha_Nacimiento = $FilaP['Fecha_Nacimiento'];
            $Telefono = $FilaP['Telefono'];
            $Id_Direccion = $FilaP['Id_Direccion'];


            $ConsultaCita = "SELECT Id_Cita, Id_Paciente FROM cita WHERE Id_Paciente =?";
            $SentenciaCita = $Conexion->prepare($ConsultaCita);
            $SentenciaCita->bind_param("i", $Id_Paciente);
            if ($SentenciaCita->execute()) {

                $resultadoCita = $SentenciaCita->get_result();

                if ($resultadoCita->num_rows > 0) {
                    $fila = $resultadoCita->fetch_assoc();
                    $Id_Cita = $fila['Id_Cita'];
                }
            }
            $SentenciaCita->close();
        } else {
            // Si no hay resultados en la tabla paciente, entonces se consulta a paciente_menor_edad
            $ConsultaPM = "SELECT Id_Paciente, Tipo_Documento, Documento_Id, Primer_Nombre, Segundo_Nombre, Primer_Apellido, Segundo_Apellido,
            Fecha_Nacimiento, Telefono, Id_Direccion FROM paciente_menoredad WHERE Id_Paciente =?";
            $SentenciaPM = $Conexion->prepare($ConsultaPM);
            $SentenciaPM->bind_param("i", $Id_Paciente);
            if ($SentenciaPM->execute()) {
                $ResultadoPM = $SentenciaPM->get_result();

                if ($ResultadoPM->num_rows > 0) {
                    $FilaPM = $ResultadoPM->fetch_assoc();

                    $Id_Paciente = $FilaPM['Id_Paciente'];
                    $Tipo_Documento = $FilaPM['Tipo_Documento'];
                    $Documento_Id = $FilaPM['Documento_Id'];
                    $Primer_Nombre = $FilaPM['Primer_Nombre'];
                    $Segundo_Nombre = $FilaPM['Segundo_Nombre'];
                    $Primer_Apellido = $FilaPM['Primer_Apellido'];
                    $Segundo_Apellido = $FilaPM['Segundo_Apellido'];
                    $Fecha_Nacimiento = $FilaPM['Fecha_Nacimiento'];
                    $Telefono = $FilaPM['Telefono'];
                    $Id_Direccion = $FilaPM['Id_Direccion'];

                    $ConsultaCita = "SELECT Id_Cita, Id_PacienteMenor FROM cita WHERE Id_PacienteMenor =?";
                    $SentenciaCita = $Conexion->prepare($ConsultaCita);
                    $SentenciaCita->bind_param("i", $Id_Paciente);
                    if ($SentenciaCita->execute()) {
                        $resultadoCita = $SentenciaCita->get_result();

                        if ($resultadoCita->num_rows > 0) {
                            $fila = $resultadoCita->fetch_assoc();
                            $Id_Cita = $fila['Id_Cita'];
                        }
                    }
                    $SentenciaCita->close();
                } else {
                    header("Location:../PHP/Historial_Clinico.php?mensaje=no_coincidencias");
                    exit();
                }
            }
        }

        $ConsultaD = "SELECT Id_Direccion, estado, municipio, parroquia, ciudad, Direccion_Vivienda FROM direccionpaciente WHERE Id_Direccion =?";
        $SentenciaD = $Conexion->prepare($ConsultaD);
        $SentenciaD->bind_param("i", $Id_Direccion);

        if ($SentenciaD->execute()) {
            $resultadoD = $SentenciaD->get_result();
            $rowD = $resultadoD->fetch_assoc();

            $estado = $rowD['estado'];
            $municipio = $rowD['municipio'];
            $parroquia = $rowD['parroquia'];
            $ciudad = $rowD['ciudad'];
            $Direccion_Vivienda = $rowD['Direccion_Vivienda'];

            $direccionCompleta = $Direccion_Vivienda . ', ' . $ciudad . ', ' . $estado . ', ' . $municipio . ', ' . $parroquia;
        }
        $SentenciaD->close();

        $ConsultaCalendario = "SELECT Id_Calendario, Id_Cita FROM calendario WHERE Id_Cita =?";
        $SentenciaCalendario = $Conexion->prepare($ConsultaCalendario);
        $SentenciaCalendario->bind_param("i", $Id_Cita);
        if ($SentenciaCalendario->execute()) {
            // Obtener el resultado como un objeto mysqli_result
            $resultadoCalendario = $SentenciaCalendario->get_result();

            if ($resultadoCalendario->num_rows > 0) {
                $fila = $resultadoCalendario->fetch_assoc();
                $Id_Calendario = $fila['Id_Calendario'];
            }
        }
        $SentenciaCalendario->close();
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emoción Vital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/menulateral.css">
    <link href="../CSS/PDF.css" rel="stylesheet">
    <link href="../CSS/nuevohistorial.css" rel="stylesheet">

    <link rel="icon" href="imagenes/favicon-16x16.png" type="image/x-icon">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>


  <!-- Comienzo del menu -->

  <div class="menu">
        <ion-icon name="menu-outline"></ion-icon>
        <ion-icon name="close-outline"></ion-icon>
    </div>

    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <ion-icon id="burguer" name="menu-outline"></ion-icon>
            </div>

        </div>

        <nav class="navegacion">
            <ul>
            <li>
            <a id="inbox" href="Menu_Psicologo.php">
                <ion-icon name="home-outline"></ion-icon>
                <span>Inicio</span>
            </a>
        </li>
        <li>
            <a href="Agendar_Cita.php">
                <ion-icon name="reader-outline"></ion-icon>
                <span>Agendar Cita</span>
            </a>
        </li>
        <li>
            <a href="Citas_Psicologo.php">
                <ion-icon name="newspaper-outline"></ion-icon>
                <span>Citas Agendadas</span>
            </a>
        </li>
        <li>
            <a href="Historial_Clinico.php">
                  <ion-icon name="id-card-outline"></ion-icon>
                <span>Historial Clinico</span>
            </a>
        </li>
        <li>
            <a href="Nuevo_Registro.php">
                <ion-icon name="document-text-outline"></ion-icon>
                <span>Registrar Usuario</span>
            </a>
        </li>
        <li>
            <a href="Configuracion_Psicologo.php">
                <ion-icon name="options-outline"></ion-icon>
                <span>Configuración</span>
            </a>
        </li>
      

                </li>
                <a href="CerrarSesion.php" class="sidebar-link">
                    <ion-icon name="log-out-outline"></ion-icon>
                    <span>Cerrar sesión</span>
                </a>
                </li>
        </nav>

    </div>
    <!-- Final del menu  -->

    <main>
   <form id="Formulario_Historial" action="../Configuracion/HistorialClinico.php" method="POST">

    <div class="container">
    <img src="../imagenes/logo marron.png" alt="Logo" class="mi-logo">

    <h1 class="display-6 fw-bold lh-1 titulo">HISTORIAL CLINICO</h1>


        <div class="row">
            <div class="col">

                <!-- Sección I. DATOS DE IDENTIFICACIÓN -->
                <div class="Datos_Identificacion">
                    <h2 class="display-6 fw-bold lh-1 fs-5">I. DATOS DE IDENTIFICACIÓN</h2>

                    <input type="hidden" id="Id_Paciente_Oculto" name="Id_Paciente" value="<?php echo $Id_Paciente; ?>">
                    <input type="hidden" id="Id_Cita_Oculto" name="Id_Cita" value="<?php echo $Id_Cita; ?>">
                    <input type="hidden" id="Id_Calendario_Oculto" name="Id_Calendario" value="<?php echo $Id_Calendario; ?>">

                    <label for="Nombre">Nombre</label><br>
                    <input type="text" class="form-control" id="Nombre" name="Nombre" value="<?php echo $Primer_Nombre . ' ' . $Segundo_Nombre . ' ' . $Primer_Apellido . ' ' . $Segundo_Apellido; ?>"><br>

                    <label for="Identificacion">Identificación</label><br>
                    <input type="text" class="form-control" id="Identificacion" name="Identificacion" value="<?php echo $Tipo_Documento . ' ' . $Documento_Id; ?>"><br>

                    <label for="Fecha_Nacimiento">Fecha de Nacimiento</label><br>
                    <input type="date" class="form-select" id="Fecha_Nacimiento" name="Fecha_Nacimiento" value="<?php echo $Fecha_Nacimiento; ?>"><br>

                    <label for="Escolaridad">Escolaridad/Profesión</label><br>
                    <input type="text" class="form-control" id="Escolaridad" name="Escolaridad"><br>

                    <label for="Promedio">Promedio</label><br>
                    <input type="number" class="form-control" id="Promedio" name="Promedio"><br>

                    <label for="Escuela">Escuela</label><br>
                    <input type="text" class="form-control" id="Escuela" name="Escuela"><br>

                    <label for="Lugar_Familia">Lugar que ocupa en la familia</label><br>
                    <input type="text" class="form-control" id="Lugar_Familia" name="Lugar_Familia"><br>

                    <label for="Direccion">Dirección:</label><br>
                    <input type="text" class="form-control" id="Direccion" name="Direccion" value="<?php echo $direccionCompleta; ?>"><br>

                    <label for="Telefono">Teléfono</label><br>
                    <input type="text" class="form-control" id="Telefono" name="Telefono" value="<?php echo $Telefono; ?>"><br>
                </div>

            </div>
            <div class="col">

                <!-- Sección II. FACTORES QUE MOTIVAN A LA CONSULTA -->
                <div class="Factor_Motiva">
                    <h2 class="display-6 fw-bold lh-1 fs-5">II. FACTORES QUE MOTIVAN A LA CONSULTA</h2>

                    <label for="Factores_Mot">Factores que motivan la consulta</label><br>
                    <textarea id="Factores_Mot" class="form-control" name="Factores_Mot" placeholder="Descripción"></textarea><br>

                    <label for="Referido_Por">Referido por</label><br>
                    <textarea id="Referido_Por" class="form-control" name="Referido_Por" placeholder="Descripción"></textarea><br>

                    <label for="Diagnostico_Orga">Diagnóstico Orgánico</label><br>
                    <textarea id="Diagnostico_Orga" class="form-control" name="Diagnostico_Orga" placeholder="Descripción"></textarea><br>

                    <label for="Actitud_Padres">Actitud de los padres ante el problema</label><br>
                    <textarea id="Actitud_Padres" class="form-control" name="Actitud_Padres" placeholder="Descripción"></textarea><br>

                    <label for="Estado_Emocional">Estado emocional actual del niño(a)</label><br>
                    <textarea id="Estado_Emocional" class="form-control" name="Estado_Emocional" placeholder="Descripción"></textarea><br>
                </div>

                <div class="Factor_Fisico">
                    <h2 class="display-6 fw-bold lh-1 fs-5">III. FACTORES FÍSICOS</h2>

                    <label for="Desarrollo_Prenatal">Desarrollo Prenatal y Natal</label><br>
                    <textarea id="Desarrollo_Prenatal" class="form-control" name="Desarrollo_Prenatal" placeholder="Descripción"></textarea><br>

                    <label for="Desarrollo_Pi">Desarrollo de la Primera Infancia</label><br>
                    <textarea id="Desarrollo_Pi" class="form-control" name="Desarrollo_Pi" placeholder="Descripción"></textarea><br>
                </div>

            </div>
        </div>
       

    
        <div class="row">
            <div class="col">
                <!-- Sección IV. FACTORES FAMILIARES -->
                <div class="Factor_Familiar">
                            <h2 class="display-6 fw-bold lh-1 fs-5">IV. FACTORES FAMILIARES</h2>
                            <h3 class="display-6 fw-bold lh-1 fs-6">Datos Familiares</h3>
                            <div class="Factor_mama">

                                <h4 class="display-6 fw-bold lh-1 fs-6">Mamá</h4>
                                <label for="Nombre_Mama">Nombre</label><br>
                                <textarea id="Nombre_Mama" class="form-control" name="Nombre_Mama" placeholder="Descripción"></textarea><br>

                                <label for="Salud_Fisica_Mama">Salud física</label><br>
                                <textarea id="Salud_Fisica_Mama" class="form-control" name="Salud_Fisica_Mama" placeholder="Descripción"></textarea><br>

                                <label for="Nivel_Educativo_Mama">Nivel educativo</label><br>
                                <textarea id="Nivel_Educativo_Mama" class="form-control" name="Nivel_Educativo_Mama" placeholder="Descripción"></textarea><br>

                                <label for="Trabajo_Actual_Mama">Trabajo actual</label><br>
                                <textarea id="Trabajo_Actual_Mama" class="form-control" name="Trabajo_Actual_Mama" placeholder="Descripción"></textarea><br>

                                <label for="Horario_Trabajo_Mama">Horario de trabajo</label><br>
                                <textarea id="Horario_Trabajo_Mama" class="form-control" name="Horario_Trabajo_Mama" placeholder="Descripción"></textarea><br>

                                <label for="Habitos_Mama">Hábitos</label><br>
                                <textarea id="Habitos_Mama" class="form-control" name="Habitos_Mama" placeholder="Descripción"></textarea><br>
                            </div>

                            <div class="Factor_papa">
                                <h4 class="display-6 fw-bold lh-1 fs-6">Papá</h4>
                                <label for="Nombre_Papa">Nombre</label><br>
                                <textarea id="Nombre_Papa" class="form-control" name="Nombre_Papa" placeholder="Descripción"></textarea><br>

                                <label for="Salud_Fisica_Papa">Salud física</label><br>
                                <textarea id="Salud_Fisica_Papa" class="form-control" name="Salud_Fisica_Papa" placeholder="Descripción"></textarea><br>

                                <label for="Nivel_Educativo_Papa">Nivel educativo</label><br>
                                <textarea id="Nivel_Educativo_Papa" class="form-control" name="Nivel_Educativo_Papa" placeholder="Descripción"></textarea><br>

                                <label for="Trabajo_Actual_Papa">Trabajo actual</label><br>
                                <textarea id="Trabajo_Actual_Papa" class="form-control" name="Trabajo_Actual_Papa" placeholder="Descripción"></textarea><br>

                                <label for="Horario_Trabajo_Papa">Horario de trabajo</label><br>
                                <textarea id="Horario_Trabajo_Papa" class="form-control" name="Horario_Trabajo_Papa" placeholder="Descripción"></textarea><br>

                                <label for="Habitos_Papa">Hábitos</label><br>
                                <textarea id="Habitos_Papa" class="form-control" name="Habitos_Papa" placeholder="Descripción"></textarea><br>
                            </div>
                </div>
            </div>

            <div class="col">
                <!-- Sección de EXPERIENCIAS TRAUMÁTICAS -->
                <div class="Experiencias_T">
                    <h3 class="display-6 fw-bold lh-1 fs-5">EXPERIENCIAS TRAUMÁTICAS</h3>

                    <h3 class="display-6 fw-bold lh-1 fs-6">Pérdida de algún familiar o ser querido</h3>
                    <label for="Quien_Era">¿Quién era?</label><br>
                    <textarea id="Quien_Era" class="form-control" name="Quien_Era" placeholder="Descripción"></textarea><br>

                    <label for="Como_Fue">¿Cómo fue?</label><br>
                    <textarea id="Como_Fue" class="form-control" name="Como_Fue" placeholder="Descripción"></textarea><br>

                    <label for="Edad_NinoPerd">¿Cuál era la edad del niño?</label><br>
                    <input type="text" class="form-control" id="Edad_NinoPerd" name="Edad_NinoPerd"><br>

                    <label for="Presencia_Suce">¿Presenció el suceso?</label><br>
                    <textarea id="Presencia_Suce" class="form-control" name="Presencia_Suce" placeholder="Descripción"></textarea><br>

                    <label for="Reaccion_Nino">¿Qué reacción mostró el niño ante esto?</label><br>
                    <textarea id="Reaccion_Nino" class="form-control" name="Reaccion_Nino" placeholder="Descripción"></textarea><br>

                    <h3 class="display-6 fw-bold lh-1 fs-6">Accidentes del niño</h3>
                    <label for="Accidente_Nino">Accidentes del niño</label><br>
                    <textarea id="Accidente_Nino" class="form-control" name="Accidente_Nino" placeholder="Descripción"></textarea><br>

                    <label for="Castigos_Graves">Castigos Graves</label><br>
                    <textarea id="Castigos_Graves" class="form-control" name="Castigos_Graves" placeholder="Descripción"></textarea><br>

                    <label for="Parte_Quien">De parte de quién</label><br>
                    <textarea id="Parte_Quien" class="form-control" name="Parte_Quien" placeholder="Descripción"></textarea><br>

                    <label for="Edad_Nino">Edad del niño</label><br>
                    <input type="text" class="form-control" id="Edad_Nino" name="Edad_Nino"><br>

                    <label for="Causante_Problema">¿Por qué son causados los problemas?</label><br>
                    <p>(personas, situaciones, experiencias, etc.)</p>
                    <textarea id="Causante_Problema" class="form-control" name="Causante_Problema" placeholder="Descripción"></textarea><br>

                    <label for="Problemas_Fisicos">Problemas Físicos</label><br>
                    <textarea id="Problemas_Fisicos" class="form-control" name="Problemas_Fisicos" placeholder="Descripción"></textarea><br>
                </div>   
            </div>
        </div>


        <div class="row">
           
            <div class="col">

                <!-- Sección V. FACTORES HEREDITARIOS -->

                <div class="Personalidad_C">
                    <h3 class="display-6 fw-bold lh-1 fs-5">V. FACTORES DE LA PERSONALIDAD Y CONDUCTA</h3>

                    <h2 class="display-6 fw-bold lh-1 fs-6">Hábitos e Intereses</h2>
                    <h3 class="display-6 fw-bold lh-1 fs-6">Comida</h3>
                    <p>(Come Bien/Demasiado/Preferencias)</p>
                    <textarea id="Comida" class="form-control" name="Comida" placeholder="Descripción"></textarea><br>

                    <h3 class="display-6 fw-bold lh-1 fs-6">Sueño</h3>
                    <p>(Duerme Bien/Intranquilo/Pesadillas/Grita en el sueño/Miedo a dormir solo/Preferencia dormir con la madre o el padre/Miedo a la obscuridad, etc)</p>
                    <textarea id="Sueno" class="form-control" name="Sueno" placeholder="Descripción"></textarea><br>

                    <h3 class="display-6 fw-bold lh-1 fs-6">Eliminaciones</h3>
                    <p>(Enuresis nocturnas/Enuresis diurnas/Se ensucia de día o de noche/Diarreas frecuentes/Estreñimiento habitual)</p>
                    <textarea id="Eliminaciones" class="form-control" name="Eliminaciones" placeholder="Descripción"></textarea><br>

                    <h3 class="display-6 fw-bold lh-1 fs-6">Manías y Tics</h3>
                    <p>(Se come las uñas/Se jala el pelo/Dedos en la nariz/Muecas faciales)</p>
                    <textarea id="ManiasTics" class="form-control" name="ManiasTics" placeholder="Descripción"></textarea><br>

                    <h3 class="display-6 fw-bold lh-1 fs-6">Historia Sexual</h3>
                    <p>(Masturbación, Seducción, Juegos sexuales, etc)</p>
                    <textarea id="HistoriaS" class="form-control" name="HistoriaS" placeholder="Descripción"></textarea><br>

                    <h3 class="display-6 fw-bold lh-1 fs-6">Rasgos Peculiares</h3>
                    <p>Tendencias Destructivas</p>
                    <textarea id="RasgosP" class="form-control" name="RasgosP" placeholder="Descripción"></textarea><br>
            </div>
        </div>

        
        

<div class="row">
    <div class="col">
        <h3 class="checktext"><input type="checkbox" id="rc_timido" name="rc_timido"> Tímido<label for="rc_timido"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_agresivo" name="rc_agresivo"> Agresivo<label for="rc_agresivo"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_tranquilo" name="rc_tranquilo"> Tranquilo<label for="rc_tranquilo"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_irritable" name="rc_irritable"> Irritable<label for="rc_irritable"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_alegre" name="rc_alegre"> Alegre<label for="rc_alegre"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_triste" name="rc_triste"> Triste<label for="rc_triste"></label></h3>
        
    </div>
    <div class="col">
        <h3 class="checktext"><input type="checkbox" id="rc_cooperador" name="rc_cooperador"> Cooperador<label for="rc_cooperador"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_negativista" name="rc_negativista"> Negativista<label for="rc_negativista"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_sereno" name="rc_sereno"> Sereno<label for="rc_sereno"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_impulsivo" name="rc_impulsivo"> Impulsivo<label for="rc_impulsivo"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_confiado_en_si" name="rc_confiado_en_si"> Confiado en sí<label for="rc_confiado_en_si"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_frio" name="rc_frio"> Frio<label for="rc_frio"></label></h3>
    </div>
 
</div>
<div class="row">
    <div class="col">
        <br>
        <h3 class="checktext"><input type="checkbox" id="rc_juega" name="rc_juega"> Juega<label for="rc_juega"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_no_juega" name="rc_no_juega"> No juega<label for="rc_no_juega"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_controlado" name="rc_controlado"> Controlado<label for="rc_controlado"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_emotivo" name="rc_emotivo"> Emotivo<label for="rc_emotivo"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_seguro" name="rc_seguro"> Seguro<label for="rc_seguro"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_amable" name="rc_amable"> Amable<label for="rc_amable"></label></h3>
        <br>
    </div>
    <div class="col">
    <br>
        <h3 class="checktext"><input type="checkbox" id="rc_desconsiderado" name="rc_desconsiderado"> Desconsiderado<label for="rc_desconsiderado"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_laborioso" name="rc_laborioso"> Laborioso<label for="rc_laborioso"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_perezoso" name="rc_perezoso"> Perezoso<label for="rc_perezoso"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_desconfiado" name="rc_desconfiado"> Desconfiado<label for="rc_desconfiado"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_dominante" name="rc_dominante"> Dominante<label for="rc_dominante"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_sumiso" name="rc_sumiso"> Sumiso<label for="rc_sumiso"></label></h3>
        <br>
    </div>

</div>
<div class="row">
    <div class="col">
    <br>
        <h3 class="checktext"><input type="checkbox" id="rc_disciplinado" name="rc_disciplinado"> Disciplinado<label for="rc_disciplinado"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_indisciplinado" name="rc_indisciplinado"> Indisciplinado<label for="rc_indisciplinado"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_rebelde" name="rc_rebelde"> Rebelde<label for="rc_rebelde"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_obediente" name="rc_obediente"> Obediente<label for="rc_obediente"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_ordenado" name="rc_ordenado"> Ordenado<label for="rc_ordenado"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_desordenado" name="rc_desordenado"> Desordenado<label for="rc_desordenado"></label></h3>
        <br>
    </div>
    <div class="col">
    <br>
        <h3 class="checktext"><input type="checkbox" id="rc_sociable" name="rc_sociable"> Sociable<label for="rc_sociable"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_retardado" name="rc_retardado"> Retardado<label for="rc_retardado"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_equilibrado" name="rc_equilibrado"> Equilibrado<label for="rc_equilibrado"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_nervioso" name="rc_nervioso"> Nervioso<label for="rc_nervioso"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_carinoso" name="rc_carinoso"> Cariñoso<label for="rc_carinoso"></label></h3>

        <h3 class="checktext"><input type="checkbox" id="rc_inseguro" name="rc_inseguro"> Inseguro<label for="rc_inseguro"></label></h3>
        <br>
    </div>
   
</div>
        

        <div class="row">
            <div class="col">
                
                <!-- Sección VI. IMPRESIÓN PSICOLÓGICA -->
                <div class="Factores_H">
                    <h2 class="display-6 fw-bold lh-1 fs-5">VI. FACTORES HEREDITARIOS</h2>
                    <h3 class="display-6 fw-bold lh-1 fs-6">Incidencia de anomalías en familiares consanguíneos</h3>
                    <p>(Familiares, Fecha, Detalles, etc.)</p>
                    <textarea id="fh_incidencias" class="form-control" name="fh_incidencias" placeholder="Descripción"></textarea><br>

                    <h3 class="display-6 fw-bold lh-1 fs-6">Tratamiento médico por nerviosismo</h3>
                    <textarea id="fh_tratamiento_medico" class="form-control" name="fh_tratamiento_medico" placeholder="Descripción"></textarea><br>

                    <h3 class="display-6 fw-bold lh-1 fs-6">Alcoholismo (grado) Manifestaciones, etc.</h3>
                    <textarea id="fh_alcolismo_etc" class="form-control" name="fh_alcolismo_etc" placeholder="Descripción"></textarea><br>

                    <h3 class="display-6 fw-bold lh-1 fs-6">Abuso de Sustancias</h3>
                    <p>(Drogas, Calmantes, etc.)</p>
                    <textarea id="fh_abuso_de_drogas" class="form-control" name="fh_abuso_de_drogas" placeholder="Descripción"></textarea><br>

                    <h3 class="display-6 fw-bold lh-1 fs-6">Debilidad Mental</h3>
                    <textarea id="fh_debilidad_mental" class="form-control" name="fh_debilidad_mental" placeholder="Descripción"></textarea><br>

                    <h3 class="display-6 fw-bold lh-1 fs-6">Síntomas</h3>
                    <p>(Convulsiones, Desmayos, Temblores, etc.)</p>
                    <textarea id="fh_sintomas" class="form-control" name="fh_sintomas" placeholder="Descripción"></textarea><br>
                    
                    <div class="Impresion_P">
                    <h2 class="display-6 fw-bold lh-1 fs-5">VII. IMPRESIÓN PSICOLÓGICA</h2>
                    <p>(Signos y síntomas, personalidad, adaptación psicológica a la enfermedad, al tratamiento, cirugía, e internamientos, relación médico-paciente-enfermera, expectativas ante la patología)</p>
                    <textarea id="Impresion" class="form-control" name="Impresion" placeholder="Descripción"></textarea><br>
                </div>

                
                </div>

            </div>
            <div class="col">
                
            <h3 class="display-6 fw-bold lh-1 fs-6">ETS</h3>
                    <p>(Enfermedades Sexuales, Formas, Motivos)</p>
                    <textarea id="fh_ets" class="form-control" name="fh_ets" placeholder="Descripción"></textarea><br>

                    <h class="display-6 fw-bold lh-1 fs-6"3>Suicidio</h3>
                    <p>(Formas, Motivos)</p>
                    <textarea id="fh_suicidio" class="form-control" name="fh_suicidio" placeholder="Descripción"></textarea><br>

                    <h3 class="display-6 fw-bold lh-1 fs-6">Anormalidades</h3>
                    <p>(Prostitución, Criminalidad, Delitos, Reclusión, etc.)</p>
                    <textarea id="fh_anormalidades" class="form-control" name="fh_anormalidades" placeholder="Descripción"></textarea><br>

                    <h3 class="display-6 fw-bold lh-1 fs-6">Trastornos del habla</h3>
                    <p>(Tartamudez, Sordera, Mudez, etc.)</p>
                    <textarea id="fh_trastornos_habla" class="form-control" name="fh_trastornos_habla" placeholder="Descripción"></textarea><br>

                    <h3 class="display-6 fw-bold lh-1 fs-6">Trastornos de la vista</h3>
                    <p>(Ceguera, Miopía, etc.)</p>
                    <textarea id="fh_trastornos_vista" class="form-control" name="fh_trastornos_vista" placeholder="Descripción"></textarea><br>

                <div class="Recomendaciones">
                    <h2 class="display-6 fw-bold lh-1 fs-5">VIII. RECOMENDACIONES</h2>
                    <textarea id="Recomendaciones" class="form-control" name="Recomendaciones" placeholder="Descripción"></textarea><br>
                </div>

                <div class="Plan_P">
                    <h3 class="display-6 fw-bold lh-1 fs-5">IX. PLAN PSICOTERAPÉUTICO</h3>
                    <textarea id="Plan" class="form-control" name="Plan" placeholder="Descripción"></textarea>
                </div>
            </div>
        </div>
       

        <button type="submit"  class="btn_Guardar btn btn-primary mi-boton" id="btn_Guardar">GUARDAR HISTORIAL</button>
        <button type="submit" class="btn_Imprimir btn btn-primary mi-boton" onclick="printPage()">IMPRIMIR HISTORIAL</button>
    </div>
    </form>

</main>
    


    <script src="../JS/SeccionPaciente.js"></script>
    <script src="../JS/PDF.js"></script>
    <script src="../JS/menulateral.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    
</body>

</html>