<?php
session_start();
include_once('Conexion_BD.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}
$Id_Empleado = $_SESSION['Id_Usuario'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    function validar($dato)
    {
        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato);
        return $dato;
    }
    // Datos de Identificacion
    $Id_Paciente = validar($_POST['Id_Paciente']) ?? 'Vacio';
    $Id_Cita = validar($_POST['Id_Cita']) ?? 'Vacio';
    $Id_Calendario = validar($_POST['Id_Calendario']) ?? 'Vacio';
    $Nombre = validar($_POST['Nombre']) ?? 'Vacio';
    $Identificacion = validar($_POST['Identificacion']) ?? 'Vacio';
    $Fecha_Nacimiento = validar($_POST['Fecha_Nacimiento']);
    $Escolaridad = validar($_POST['Escolaridad']) ?? 'Vacio';
    $Promedio = validar($_POST['Promedio']) ?? 'Vacio';
    $Escuela = validar($_POST['Escuela']) ?? 'Vacio';
    $Lugar_Familia = validar($_POST['Lugar_Familia']) ?? 'Vacio';
    $Direccion = validar($_POST['Direccion']) ?? 'Vacio';
    $Telefono = validar($_POST['Telefono']) ?? 'Vacio';

    //Factores Motivan la Consulta
    $Factores_Mot = validar($_POST['Factores_Mot']) ?? 'Vacio';
    $Referido_Por = validar($_POST['Referido_Por']) ?? 'Vacio';
    $Diagnostico_Orga = validar($_POST['Diagnostico_Orga']) ?? 'Vacio';
    $Actitud_Padres = validar($_POST['Actitud_Padres']) ?? 'Vacio';
    $Estado_Emocional = validar($_POST['Estado_Emocional']) ?? 'Vacio';

    // Factores Físico
    $Desarrollo_Prenatal = validar($_POST['Desarrollo_Prenatal']) ?? 'Vacio';
    $Desarrollo_Pi = validar($_POST['Desarrollo_Pi']) ?? 'Vacio';

    // Factores Familiares
    $Nombre_Mama = validar($_POST['Nombre_Mama']) ?? '';
    $Salud_Fisica_Mama = validar($_POST['Salud_Fisica_Mama']) ?? 'Vacio';
    $Nivel_Educativo_Mama = validar($_POST['Nivel_Educativo_Mama']) ?? 'Vacio';
    $Trabajo_Actual_Mama = validar($_POST['Trabajo_Actual_Mama']) ?? 'Vacio';
    $Horario_Trabajo_Mama = validar($_POST['Horario_Trabajo_Mama']) ?? 'Vacio';
    $Habitos_Mama = validar($_POST['Habitos_Mama']) ?? 'Vacio';

    $Nombre_Papa = validar($_POST['Nombre_Papa']) ?? 'Vacio';
    $Salud_Fisica_Papa = validar($_POST['Salud_Fisica_Papa']) ?? 'Vacio';
    $Nivel_Educativo_Papa = validar($_POST['Nivel_Educativo_Papa']) ?? 'Vacio';
    $Trabajo_Actual_Papa = validar($_POST['Trabajo_Actual_Papa']) ?? 'Vacio';
    $Horario_Trabajo_Papa = validar($_POST['Horario_Trabajo_Papa']) ?? 'Vacio';
    $Habitos_Papa = validar($_POST['Habitos_Papa']) ?? 'Vacio';

    //Experiencias Traumaticas
    $Quien_Era = validar($_POST['Quien_Era']) ?? 'Vacio';
    $Como_Fue = validar($_POST['Como_Fue']) ?? 'Vacio';
    $Edad_NinoPerd = validar($_POST['Edad_NinoPerd']) ?? 'Vacio';
    $Presencia_Suce = validar($_POST['Presencia_Suce']) ?? 'Vacio';
    $Reaccion_Nino = validar($_POST['Reaccion_Nino']) ?? 'Vacio';
    $Accidente_Nino = validar($_POST['Accidente_Nino']) ?? 'Vacio';
    $Castigos_Graves = validar($_POST['Castigos_Graves']) ?? 'Vacio';
    $Parte_Quien = validar($_POST['Parte_Quien']) ?? 'Vacio';
    $Edad_Nino = validar($_POST['Edad_Nino']) ?? 'Vacio';
    $Causante_Problema = validar($_POST['Causante_Problema']) ?? 'Vacio';
    $Problemas_Fisicos = validar($_POST['Problemas_Fisicos']) ?? 'Vacio';

    // Personalidad y Conducta
    $Comida = validar($_POST['Comida']) ?? 'Vacio';
    $Sueno = validar($_POST['Sueno']) ?? 'Vacio';
    $Eliminaciones = validar($_POST['Eliminaciones']) ?? 'Vacio';
    $ManiasTics = validar($_POST['ManiasTics']) ?? 'Vacio';
    $HistoriaS = validar($_POST['HistoriaS']) ?? 'Vacio';
    $RasgosP = validar($_POST['RasgosP']) ?? 'Vacio';

    $rc_timido = isset($_POST['rc_timido']) ? 1 : 0;
    $rc_agresivo = isset($_POST['rc_agresivo']) ? 1 : 0;
    $rc_tranquilo = isset($_POST['rc_tranquilo']) ? 1 : 0;
    $rc_irritable = isset($_POST['rc_irritable']) ? 1 : 0;
    $rc_alegre = isset($_POST['rc_alegre']) ? 1 : 0;
    $rc_triste = isset($_POST['rc_triste']) ? 1 : 0;
    $rc_cooperador = isset($_POST['rc_cooperador']) ? 1 : 0;
    $rc_negativista = isset($_POST['rc_negativista']) ? 1 : 0;
    $rc_sereno = isset($_POST['rc_sereno']) ? 1 : 0;
    $rc_impulsivo = isset($_POST['rc_impulsivo']) ? 1 : 0;
    $rc_confiado_en_si = isset($_POST['rc_confiado_en_si']) ? 1 : 0;
    $rc_frio = isset($_POST['rc_frio']) ? 1 : 0;
    $rc_sociable = isset($_POST['rc_sociable']) ? 1 : 0;
    $rc_retardado = isset($_POST['rc_retardado']) ? 1 : 0;
    $rc_equilibrado = isset($_POST['rc_equilibrado']) ? 1 : 0;
    $rc_nervioso = isset($_POST['rc_nervioso']) ? 1 : 0;
    $rc_carinoso = isset($_POST['rc_carinoso']) ? 1 : 0;
    $rc_inseguro = isset($_POST['rc_inseguro']) ? 1 : 0;
    $rc_juega = isset($_POST['rc_juega']) ? 1 : 0;
    $rc_no_juega = isset($_POST['rc_no_juega']) ? 1 : 0;
    $rc_controlado = isset($_POST['rc_controlado']) ? 1 : 0;
    $rc_emotivo = isset($_POST['rc_emotivo']) ? 1 : 0;
    $rc_seguro = isset($_POST['rc_seguro']) ? 1 : 0;
    $rc_amable = isset($_POST['rc_amable']) ? 1 : 0;
    $rc_desconsiderado = isset($_POST['rc_desconsiderado']) ? 1 : 0;
    $rc_laborioso = isset($_POST['rc_laborioso']) ? 1 : 0;
    $rc_perezoso = isset($_POST['rc_perezoso']) ? 1 : 0;
    $rc_desconfiado = isset($_POST['rc_desconfiado']) ? 1 : 0;
    $rc_dominante = isset($_POST['rc_dominante']) ? 1 : 0;
    $rc_sumiso = isset($_POST['rc_sumiso']) ? 1 : 0;
    $rc_disciplinado = isset($_POST['rc_disciplinado']) ? 1 : 0;
    $rc_indisciplinado = isset($_POST['rc_indisciplinado']) ? 1 : 0;
    $rc_rebelde = isset($_POST['rc_rebelde']) ? 1 : 0;
    $rc_obediente = isset($_POST['rc_obediente']) ? 1 : 0;
    $rc_ordenado = isset($_POST['rc_ordenado']) ? 1 : 0;
    $rc_desordenado = isset($_POST['rc_desordenado']) ? 1 : 0;


    //Factores Hereditarios
    $fh_incidencias = validar($_POST['fh_incidencias']) ?? 'Vacio';
    $fh_tratamiento_medico = validar($_POST['fh_tratamiento_medico']) ?? 'Vacio';
    $fh_alcolismo_etc = validar($_POST['fh_alcolismo_etc']) ?? 'Vacio';
    $fh_abuso_de_drogas = validar($_POST['fh_abuso_de_drogas']) ?? 'Vacio';
    $fh_debilidad_mental = validar($_POST['fh_debilidad_mental']) ?? 'Vacio';
    $fh_sintomas = validar($_POST['fh_sintomas']) ?? 'Vacio';
    $fh_ets = validar($_POST['fh_ets']) ?? 'Vacio';
    $fh_suicidio = validar($_POST['fh_suicidio']) ?? 'Vacio';
    $fh_anormalidades = validar($_POST['fh_anormalidades']) ?? 'Vacio';
    $fh_trastornos_habla = validar($_POST['fh_trastornos_habla']) ?? 'Vacio';
    $fh_trastornos_vista = validar($_POST['fh_trastornos_vista']) ?? 'Vacio';

    // Impresion Psicologo
    $Impresion = validar($_POST['Impresion']) ?? 'Vacio';

    // Recomendaciones
    $Recomendaciones = validar($_POST['Recomendaciones']) ?? 'Vacio';

    // Plan Psicoterapeutico
    $Plan = validar($_POST['Plan']) ?? 'Vacio';


    $ConsultaActualizarCita = "UPDATE cita SET Status_Cita = 'Finalizada' WHERE Id_Cita =?";
    $DeclaracionActualizarCita = $Conexion->prepare($ConsultaActualizarCita);
    $DeclaracionActualizarCita->bind_param("i", $Id_Cita);
    $DeclaracionActualizarCita->execute();
    //Validar la fecha de Nacimiento
    $fechaNacimiento = new DateTime($Fecha_Nacimiento);
    $fechaActual = new DateTime();
    // Calcular la diferencia entre ambas fechas en años
    $edad = $fechaActual->diff($fechaNacimiento)->y;

    if ($edad >= 18) { //Si es mayor de edad guardar Id_Paciente en paciente

        //Datos Identificacion
        $ConsultaP = "INSERT INTO datos_identificacion (Id_Paciente, Nombre, Identificacion, Fecha_Nacimiento, Escolaridad, Promedio, Escuela, Lugar_Familia, Direccion, Telefono, Fecha) VALUES (?,?,?,?,?,?,?,?,?,?, NOW())";
        $SentenciaP = $Conexion->prepare($ConsultaP);
        $SentenciaP->bind_param("ssssssssss", $Id_Paciente, $Nombre, $Identificacion, $Fecha_Nacimiento, $Escolaridad, $Promedio, $Escuela, $Lugar_Familia, $Direccion, $Telefono);
        $SentenciaP->execute();
        $Id_Datos = $SentenciaP->insert_id;

        //Factores Motivan la Consulta
        $ConsultaFC = "INSERT INTO factores_consulta (Id_Paciente, Factores_Mot, Referido_Por, Diagnostico_Orga, Actitud_Padres, Estado_Emocional, Fecha) VALUES (?,?,?,?,?,?, NOW())";
        $SentenciaFC = $Conexion->prepare($ConsultaFC);
        $SentenciaFC->bind_param("isssss", $Id_Paciente, $Factores_Mot, $Referido_Por, $Diagnostico_Orga, $Actitud_Padres, $Estado_Emocional);
        $SentenciaFC->execute();
        $Id_Factoresmc = $SentenciaFC->insert_id;

        //Factores Físicos
        $ConsultaFF = "INSERT INTO factores_fisicos (Id_Paciente, Desarrollo_Prenatal, Desarrollo_Pi, Fecha) VALUES (?,?,?, NOW())";
        $SentenciaFF = $Conexion->prepare($ConsultaFF);
        $SentenciaFF->bind_param("iss", $Id_Paciente, $Desarrollo_Prenatal, $Desarrollo_Pi);
        $SentenciaFF->execute();
        $Id_FactorF = $SentenciaFF->insert_id;

        // Factores Familiares
        $ConsultaFM = "INSERT INTO factores_familiares (Id_Paciente, Nombre_Papa, Nombre_Mama, Salud_Fisica_Papa, Salud_Fisica_Mama, Nivel_Educativo_Papa, Nivel_Educativo_Mama, Trabajo_Actual_Papa, Trabajo_Actual_Mama, Horario_Trabajo_Papa, Horario_Trabajo_Mama, Habitos_Papa, Habitos_Mama, Fecha) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?, NOW())";
        $SentenciaFM = $Conexion->prepare($ConsultaFM);
        $SentenciaFM->bind_param("issssssssssss", $Id_Paciente, $Nombre_Papa, $Nombre_Mama, $Salud_Fisica_Papa, $Salud_Fisica_Mama, $Nivel_Educativo_Papa, $Nivel_Educativo_Mama, $Trabajo_Actual_Papa, $Trabajo_Actual_Mama, $Horario_Trabajo_Papa, $Horario_Trabajo_Mama, $Habitos_Papa, $Habitos_Mama);
        $SentenciaFM->execute();
        $Id_FactorFm = $SentenciaFM->insert_id;

        //Experiencias Traumaticas
        $ConsultaTrauma = "INSERT INTO experiencia_traumatica (Id_Trauma, Id_Paciente, Quien_Era, Como_Fue, Edad_NinoPerd, Presencia_Suce, Reaccion_Nino, Accidente_Nino, Castigos_Graves, Parte_Quien, Edad_Nino, Causante_Problema, Problemas_Fisicos, Fecha) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?, NOW())";
        $SentenciaTrauma = $Conexion->prepare($ConsultaTrauma);
        $SentenciaTrauma->bind_param("issiissssssss", $Id_Trauma, $Id_Paciente, $Quien_Era, $Como_Fue, $Edad_NinoPerd, $Presencia_Suce, $Reaccion_Nino, $Accidente_Nino, $Castigos_Graves, $Parte_Quien, $Edad_Nino, $Causante_Problema, $Problemas_Fisicos);
        $SentenciaTrauma->execute();
        $Id_Trauma = $SentenciaTrauma->insert_id;

        // Personalidad y Conducta
        $ConsultaHabitos = "INSERT INTO habitos_e_intereses (Id_Paciente, Comida, Sueno, Eliminaciones, ManiasTics, HistoriaS, RasgosP, Fecha) VALUES (?,?,?,?,?,?,?, NOW())";
        $SentenciaHabitos = $Conexion->prepare($ConsultaHabitos);
        $SentenciaHabitos->bind_param("issssss",  $Id_Paciente, $Comida, $Sueno, $Eliminaciones, $ManiasTics, $HistoriaS, $RasgosP);
        $SentenciaHabitos->execute();
        $Id_Habito = $SentenciaHabitos->insert_id;

        //Rasgos Caracter
        $ConsultaRasgos = "INSERT INTO rasgos_caracter (Id_Paciente, rc_timido, rc_agresivo, rc_tranquilo, rc_irritable, rc_alegre, rc_triste, rc_cooperador, rc_negativista, rc_sereno, rc_impulsivo, rc_confiado_en_si, rc_frio, rc_sociable, rc_retardado, rc_equilibrado, rc_nervioso, rc_carinoso, rc_inseguro, rc_juega, rc_no_juega, rc_controlado, rc_emotivo, rc_seguro, rc_amable, rc_desconsiderado, rc_laborioso, rc_perezoso, rc_desconfiado, rc_dominante, rc_sumiso, rc_disciplinado,rc_indisciplinado, rc_rebelde, rc_obediente, rc_ordenado, rc_desordenado, Fecha) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
        $SentenciaRasgos = $Conexion->prepare($ConsultaRasgos);
        $SentenciaRasgos->bind_param("iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii", $Id_Paciente, $rc_timido, $rc_agresivo, $rc_tranquilo, $rc_irritable, $rc_alegre, $rc_triste, $rc_cooperador, $rc_negativista, $rc_sereno, $rc_impulsivo, $rc_confiado_en_si, $rc_frio, $rc_sociable, $rc_retardado, $rc_equilibrado, $rc_nervioso, $rc_carinoso, $rc_inseguro, $rc_juega, $rc_no_juega, $rc_controlado, $rc_emotivo, $rc_seguro, $rc_amable, $rc_desconsiderado, $rc_laborioso, $rc_perezoso, $rc_desconfiado, $rc_dominante, $rc_sumiso, $rc_disciplinado, $rc_indisciplinado, $rc_rebelde, $rc_obediente, $rc_ordenado, $rc_desordenado);
        $SentenciaRasgos->execute();
        $Id_Rc = $SentenciaRasgos->insert_id;

        //Factores Hereditarios
        $ConsultaFH = "INSERT INTO factores_hereditarios (Id_Paciente, fh_incidencias, fh_tratamiento_medico, fh_alcolismo_etc, fh_abuso_de_drogas, fh_debilidad_mental, fh_sintomas, fh_ets, fh_suicidio, fh_anormalidades, fh_trastornos_habla, fh_trastornos_vista, Fecha) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
        $SentenciaFH = $Conexion->prepare($ConsultaFH);
        $SentenciaFH->bind_param("isssssssssss", $Id_Paciente, $fh_incidencias, $fh_tratamiento_medico, $fh_alcolismo_etc, $fh_abuso_de_drogas, $fh_debilidad_mental, $fh_sintomas, $fh_ets, $fh_suicidio, $fh_anormalidades, $fh_trastornos_habla, $fh_trastornos_vista);
        $SentenciaFH->execute();
        $Id_FactoresHr = $SentenciaFH->insert_id;

        // Impresion Psicologo
        $ConsultaImpresion = "INSERT INTO impresion_psicologica (Id_Paciente,Impresion, Fecha) VALUES (?,?,NOW())";
        $SentenciaImpresion = $Conexion->prepare($ConsultaImpresion);
        $SentenciaImpresion->bind_param("is", $Id_Paciente, $Impresion);
        $SentenciaImpresion->execute();
        $Id_Impresion = $SentenciaImpresion->insert_id;

        // Recomendaciones
        $ConsultaRecomendaciones = "INSERT INTO recomendaciones (Id_Paciente,Recomendaciones, Fecha) VALUES (?,?,NOW())";
        $SentenciaRecomendaciones = $Conexion->prepare($ConsultaRecomendaciones);
        $SentenciaRecomendaciones->bind_param("is", $Id_Paciente, $Recomendaciones);
        $SentenciaRecomendaciones->execute();
        $Id_Recomendaciones = $SentenciaRecomendaciones->insert_id;

        // Plan Psicoterapeutico
        $ConsultaPlan = "INSERT INTO plan_psicoterapeutico (Id_Paciente,Plan, Fecha) VALUES (?,?,NOW())";
        $SentenciaPlan = $Conexion->prepare($ConsultaPlan);
        $SentenciaPlan->bind_param("is", $Id_Paciente, $Plan);
        $SentenciaPlan->execute();
        $Id_Plan = $SentenciaPlan->insert_id;

        //Historial Clinico
        $ConsultaPlan = "INSERT INTO historial_clinico (Id_Paciente, Id_Empleado, Id_Cita, Id_Calendario, Id_Datos, Id_Factoresmc, Id_FactorF, Id_FactorFm, Id_Trauma, Id_Habito, Id_Rc, Id_FactoresHr, Id_Impresion , Id_Recomendaciones, Id_Plan, Fecha) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
        $SentenciaPlan = $Conexion->prepare($ConsultaPlan);
        $SentenciaPlan->bind_param("iiiiiiiiiiiiiii", $Id_Paciente, $Id_Empleado, $Id_Cita, $Id_Calendario, $Id_Datos, $Id_Factoresmc, $Id_FactorF, $Id_FactorFm, $Id_Trauma, $Id_Habito, $Id_Rc, $Id_FactoresHr, $Id_Impresion, $Id_Recomendaciones, $Id_Plan);
        $SentenciaPlan->execute();
        $Id_Plan = $SentenciaPlan->insert_id;

        header("Location: ../PHP/Historial_Clinico.php?sucess=Historial_Clinico_Exitoso");
    } else {
        //Datos Identificacion
        $ConsultaP = "INSERT INTO datos_identificacion (Id_Pacientemenor, Nombre, Identificacion, Fecha_Nacimiento, Escolaridad, Promedio, Escuela, Lugar_Familia, Direccion, Telefono, Fecha) VALUES (?,?,?,?,?,?,?,?,?,?, NOW())";
        $SentenciaP = $Conexion->prepare($ConsultaP);
        $SentenciaP->bind_param("isssssssss", $Id_Paciente, $Nombre, $Identificacion, $Fecha_Nacimiento, $Escolaridad, $Promedio, $Escuela, $Lugar_Familia, $Direccion, $Telefono);
        $SentenciaP->execute();
        $Id_Datos = $SentenciaP->insert_id;

        //Factores Motivan la Consulta
        $ConsultaFC = "INSERT INTO factores_consulta (Id_Pacientemenor, Factores_Mot, Referido_Por, Diagnostico_Orga, Actitud_Padres, Estado_Emocional, Fecha) VALUES (?,?,?,?,?,?, NOW())";
        $SentenciaFC = $Conexion->prepare($ConsultaFC);
        $SentenciaFC->bind_param("isssss", $Id_Paciente, $Factores_Mot, $Referido_Por, $Diagnostico_Orga, $Actitud_Padres, $Estado_Emocional);
        $SentenciaFC->execute();
        $Id_Factoresmc = $SentenciaFC->insert_id;


        //Factores Físicos
        $ConsultaFF = "INSERT INTO factores_fisicos (Id_Pacientemenor, Desarrollo_Prenatal, Desarrollo_Pi, Fecha) VALUES (?,?,?, NOW())";
        $SentenciaFF = $Conexion->prepare($ConsultaFF);
        $SentenciaFF->bind_param("iss", $Id_Paciente, $Desarrollo_Prenatal, $Desarrollo_Pi);
        $SentenciaFF->execute();
        $Id_FactorF = $SentenciaFF->insert_id;

        // Factores Familiares
        $ConsultaFM = "INSERT INTO factores_familiares (Id_Pacientemenor, Nombre_Papa, Nombre_Mama, Salud_Fisica_Papa, Salud_Fisica_Mama, Nivel_Educativo_Papa, Nivel_Educativo_Mama, Trabajo_Actual_Papa, Trabajo_Actual_Mama, Horario_Trabajo_Papa, Horario_Trabajo_Mama, Habitos_Papa, Habitos_Mama, Fecha) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?, NOW())";
        $SentenciaFM = $Conexion->prepare($ConsultaFM);
        $SentenciaFM->bind_param("issssssssssss", $Id_Paciente, $Nombre_Papa, $Nombre_Mama, $Salud_Fisica_Papa, $Salud_Fisica_Mama, $Nivel_Educativo_Papa, $Nivel_Educativo_Mama, $Trabajo_Actual_Papa, $Trabajo_Actual_Mama, $Horario_Trabajo_Papa, $Horario_Trabajo_Mama, $Habitos_Papa, $Habitos_Mama);
        $SentenciaFM->execute();
        $Id_FactorFm = $SentenciaFM->insert_id;

        //Experiencias Traumaticas
        $ConsultaTrauma = "INSERT INTO experiencia_traumatica (Id_Pacientemenor, Quien_Era, Como_Fue, Edad_NinoPerd, Presencia_Suce, Reaccion_Nino, Accidente_Nino, Castigos_Graves, Parte_Quien, Edad_Nino, Causante_Problema, Problemas_Fisicos, Fecha) VALUES (?,?,?,?,?,?,?,?,?,?,?,?, NOW())";
        $SentenciaTrauma = $Conexion->prepare($ConsultaTrauma);
        $SentenciaTrauma->bind_param("issiisssssss",  $Id_Paciente, $Quien_Era, $Como_Fue, $Edad_NinoPerd, $Presencia_Suce, $Reaccion_Nino, $Accidente_Nino, $Castigos_Graves, $Parte_Quien, $Edad_Nino, $Causante_Problema, $Problemas_Fisicos);
        $SentenciaTrauma->execute();
        $Id_Trauma = $SentenciaTrauma->insert_id;

        // Personalidad y Conducta
        $ConsultaHabitos = "INSERT INTO habitos_e_intereses (Id_Pacientemenor, Comida, Sueno, Eliminaciones, ManiasTics, HistoriaS, RasgosP, Fecha) VALUES (?,?,?,?,?,?,?, NOW())";
        $SentenciaHabitos = $Conexion->prepare($ConsultaHabitos);
        $SentenciaHabitos->bind_param("issssss",  $Id_Paciente, $Comida, $Sueno, $Eliminaciones, $ManiasTics, $HistoriaS, $RasgosP);
        $SentenciaHabitos->execute();
        $Id_Habito = $SentenciaHabitos->insert_id;

        //Rasgos Caracter
        $ConsultaRasgos = "INSERT INTO rasgos_caracter (Id_Pacientemenor, rc_timido, rc_agresivo, rc_tranquilo, rc_irritable, rc_alegre, rc_triste, rc_cooperador, rc_negativista, rc_sereno, rc_impulsivo, rc_confiado_en_si, rc_frio, rc_sociable, rc_retardado, rc_equilibrado, rc_nervioso, rc_carinoso, rc_inseguro, rc_juega, rc_no_juega, rc_controlado, rc_emotivo, rc_seguro, rc_amable, rc_desconsiderado, rc_laborioso, rc_perezoso, rc_desconfiado, rc_dominante, rc_sumiso, rc_disciplinado,rc_indisciplinado, rc_rebelde, rc_obediente, rc_ordenado, rc_desordenado, Fecha) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
        $SentenciaRasgos = $Conexion->prepare($ConsultaRasgos);
        $SentenciaRasgos->bind_param("iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii", $Id_Paciente, $rc_timido, $rc_agresivo, $rc_tranquilo, $rc_irritable, $rc_alegre, $rc_triste, $rc_cooperador, $rc_negativista, $rc_sereno, $rc_impulsivo, $rc_confiado_en_si, $rc_frio, $rc_sociable, $rc_retardado, $rc_equilibrado, $rc_nervioso, $rc_carinoso, $rc_inseguro, $rc_juega, $rc_no_juega, $rc_controlado, $rc_emotivo, $rc_seguro, $rc_amable, $rc_desconsiderado, $rc_laborioso, $rc_perezoso, $rc_desconfiado, $rc_dominante, $rc_sumiso, $rc_disciplinado, $rc_indisciplinado, $rc_rebelde, $rc_obediente, $rc_ordenado, $rc_desordenado);
        $SentenciaRasgos->execute();
        $Id_Rc = $SentenciaRasgos->insert_id;

        //Factores Hereditarios
        $ConsultaFH = "INSERT INTO factores_hereditarios (Id_Pacientemenor, fh_incidencias, fh_tratamiento_medico, fh_alcolismo_etc, fh_abuso_de_drogas, fh_debilidad_mental, fh_sintomas, fh_ets, fh_suicidio, fh_anormalidades, fh_trastornos_habla, fh_trastornos_vista, Fecha) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
        $SentenciaFH = $Conexion->prepare($ConsultaFH);
        $SentenciaFH->bind_param("isssssssssss", $Id_Paciente, $fh_incidencias, $fh_tratamiento_medico, $fh_alcolismo_etc, $fh_abuso_de_drogas, $fh_debilidad_mental, $fh_sintomas, $fh_ets, $fh_suicidio, $fh_anormalidades, $fh_trastornos_habla, $fh_trastornos_vista);
        $SentenciaFH->execute();
        $Id_FactoresHr = $SentenciaFH->insert_id;

        // Impresion Psicologo
        $ConsultaImpresion = "INSERT INTO impresion_psicologica (Id_Pacientemenor,Impresion, Fecha) VALUES (?,?,NOW())";
        $SentenciaImpresion = $Conexion->prepare($ConsultaImpresion);
        $SentenciaImpresion->bind_param("is", $Id_Paciente, $Impresion);
        $SentenciaImpresion->execute();
        $Id_Impresion = $SentenciaImpresion->insert_id;

        // Recomendaciones
        $ConsultaRecomendaciones = "INSERT INTO recomendaciones (Id_Pacientemenor,Recomendaciones, Fecha) VALUES (?,?,NOW())";
        $SentenciaRecomendaciones = $Conexion->prepare($ConsultaRecomendaciones);
        $SentenciaRecomendaciones->bind_param("is", $Id_Paciente, $Recomendaciones);
        $SentenciaRecomendaciones->execute();
        $Id_Recomendaciones = $SentenciaRecomendaciones->insert_id;

        // Plan Psicoterapeutico
        $ConsultaPlan = "INSERT INTO plan_psicoterapeutico (Id_Pacientemenor,Plan, Fecha) VALUES (?,?,NOW())";
        $SentenciaPlan = $Conexion->prepare($ConsultaPlan);
        $SentenciaPlan->bind_param("is", $Id_Paciente, $Plan);
        $SentenciaPlan->execute();
        $Id_Plan = $SentenciaPlan->insert_id;

        //Historial Clinico
        $ConsultaPlan = "INSERT INTO historial_clinico (Id_Pacientemenor, Id_Empleado, Id_Cita, Id_Calendario, Id_Datos, Id_Factoresmc, Id_FactorF, Id_FactorFm, Id_Trauma, Id_Habito, Id_Rc, Id_FactoresHr, Id_Impresion , Id_Recomendaciones, Id_Plan, Fecha) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
        $SentenciaPlan = $Conexion->prepare($ConsultaPlan);
        $SentenciaPlan->bind_param("iiiiiiiiiiiiiii", $Id_Paciente, $Id_Empleado, $Id_Cita, $Id_Calendario, $Id_Datos, $Id_Factoresmc, $Id_FactorF, $Id_FactorFm, $Id_Trauma, $Id_Habito, $Id_Rc, $Id_FactoresHr, $Id_Impresion, $Id_Recomendaciones, $Id_Plan);
        $SentenciaPlan->execute();
        $Id_Plan = $SentenciaPlan->insert_id;

        header("Location: ../PHP/Historial_Clinico.php?sucess=Historial_Clinico_Exitoso");
    }
}else{
    header("Location: ../PHP/Historial_Clinico.php?error=Error_Historial_Clinico");
}
