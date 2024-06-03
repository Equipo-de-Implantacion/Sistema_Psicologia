<?php
include_once('Conexion_BD.php');

if ($Conexion->connect_error) {
    die("Conexión fallida: " . $Conexion->connect_error);
}

if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    switch ($accion) {
        case 'estados':
            $resultado = $Conexion->query("SELECT id_estado, estado FROM estados");
            $dato = array();
            while ($fila = $resultado->fetch_assoc()) {
                $dato[] = $fila;
            }
            echo json_encode($dato);
            break;
        case 'municipios':
            $resultado = $Conexion->query("SELECT id_municipio, id_estado, municipio FROM municipios WHERE id_estado = $id");
            $dato = array();
            while ($fila = $resultado->fetch_assoc()) {
                $dato[] = $fila;
            }
            echo json_encode($dato);
            break;
        case 'parroquias':
            $resultado = $Conexion->query("SELECT id_parroquia, id_municipio, parroquia FROM parroquias WHERE id_municipio = $id");
            $dato = array();
            while ($fila = $resultado->fetch_assoc()) {
                $dato[] = $fila;
            }
            echo json_encode($dato);
            break;
        case 'ciudades':
            $resultado = $Conexion->query("SELECT id_ciudad, id_estado, ciudad FROM ciudades WHERE id_estado = $id");
            $dato = array();
            while ($fila = $resultado->fetch_assoc()) {
                $dato[] = $fila;
            }
            echo json_encode($dato);
            break;
        case 'guardarDireccion':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : null;

                echo json_encode(['status' => 'success', 'message' => 'Dirección recibida']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Solicitud no permitida']);
            }
            break;
    }
}
