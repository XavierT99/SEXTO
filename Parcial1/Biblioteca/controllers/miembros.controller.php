<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

require_once('../models/miembros.model.php');
error_reporting(0);
$miembros = new Miembros();

$response = [
    'status' => 'error',
    'message' => 'Invalid operation',
    'data' => null
];

switch ($_GET["op"]) {
    case 'todos':
        $datos = $miembros->todos();
        $miembrosArray = [];
        while ($row = mysqli_fetch_assoc($datos)) {
            $miembrosArray[] = $row;
        }
        if (count($miembrosArray) > 0) {
            $response = [
                'status' => 'success',
                'message' => 'Miembros retrieved successfully',
                'data' => $miembrosArray
            ];
        }
        echo json_encode($response);
        break;

    case 'uno':
        if (isset($_POST["miembro_id"])) {
            $miembro_id = intval($_POST["miembro_id"]);
            $datos = $miembros->uno($miembro_id);
            $miembro = mysqli_fetch_assoc($datos);
            if ($miembro) {
                $response = [
                    'status' => 'success',
                    'message' => 'Miembro retrieved successfully',
                    'data' => $miembro
                ];
            }
        } else {
            $response['message'] = 'Missing miembro_id';
        }
        echo json_encode($response);
        break;

    case 'insertar':
        if (isset($_POST["nombre"], $_POST["apellido"], $_POST["email"], $_POST["fecha_suscripcion"])) {
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $email = $_POST["email"];
            $fecha_suscripcion = $_POST["fecha_suscripcion"];
            
            $datos = $miembros->insertar($nombre, $apellido, $email, $fecha_suscripcion);
            if ($datos) {
                $response = [
                    'status' => 'success',
                    'message' => 'Miembro inserted successfully',
                    'data' => $datos
                ];
            }
        } else {
            $response['message'] = 'Missing required fields';
        }
        echo json_encode($response);
        break;

    case 'actualizar':
        if (isset($_POST["miembro_id"], $_POST["nombre"], $_POST["apellido"], $_POST["email"], $_POST["fecha_suscripcion"])) {
            $miembro_id = intval($_POST["miembro_id"]);
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $email = $_POST["email"];
            $fecha_suscripcion = $_POST["fecha_suscripcion"];
            
            $datos = $miembros->actualizar($miembro_id, $nombre, $apellido, $email, $fecha_suscripcion);
            if ($datos) {
                $response = [
                    'status' => 'success',
                    'message' => 'Miembro updated successfully',
                    'data' => $datos
                ];
            }
        } else {
            $response['message'] = 'Missing required fields';
        }
        echo json_encode($response);
        break;

    case 'eliminar':
        if (isset($_POST["miembro_id"])) {
            $miembro_id = intval($_POST["miembro_id"]);
            $datos = $miembros->eliminar($miembro_id);
            if ($datos) {
                $response = [
                    'status' => 'success',
                    'message' => 'Miembro deleted successfully',
                    'data' => $datos
                ];
            }
        } else {
            $response['message'] = 'Missing miembro_id';
        }
        echo json_encode($response);
        break;
}
