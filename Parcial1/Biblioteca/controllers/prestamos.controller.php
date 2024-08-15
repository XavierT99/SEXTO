<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

require_once('../models/prestamos.model.php');
error_reporting(0);
$prestamos = new Prestamos();

$response = [
    'status' => 'error',
    'message' => 'Invalid operation',
    'data' => null
];

switch ($_GET["op"]) {
    case 'todos':
        $datos = $prestamos->todos();
        $prestamosArray = [];
        while ($row = mysqli_fetch_assoc($datos)) {
            $prestamosArray[] = $row;
        }
        if (count($prestamosArray) > 0) {
            $response = [
                'status' => 'success',
                'message' => 'Prestamos retrieved successfully',
                'data' => $prestamosArray
            ];
        }
        echo json_encode($response);
        break;

    case 'uno':
        if (isset($_POST["prestamo_id"])) {
            $prestamo_id = intval($_POST["prestamo_id"]);
            $datos = $prestamos->uno($prestamo_id);
            $prestamo = mysqli_fetch_assoc($datos);
            if ($prestamo) {
                $response = [
                    'status' => 'success',
                    'message' => 'Prestamo retrieved successfully',
                    'data' => $prestamo
                ];
            }
        } else {
            $response['message'] = 'Missing prestamo_id';
        }
        echo json_encode($response);
        break;

    case 'insertar':
        if (isset($_POST["libro_id"], $_POST["miembro_id"], $_POST["fecha_prestamo"], $_POST["fecha_devolucion"])) {
            $libro_id = $_POST["libro_id"];
            $miembro_id = $_POST["miembro_id"];
            $fecha_prestamo = $_POST["fecha_prestamo"];
            $fecha_devolucion = $_POST["fecha_devolucion"];
            
            $datos = $prestamos->insertar($libro_id, $miembro_id, $fecha_prestamo, $fecha_devolucion);
            if ($datos) {
                $response = [
                    'status' => 'success',
                    'message' => 'Prestamo inserted successfully',
                    'data' => $datos
                ];
            }
        } else {
            $response['message'] = 'Missing required fields';
        }
        echo json_encode($response);
        break;

    case 'actualizar':
        if (isset($_POST["prestamo_id"], $_POST["libro_id"], $_POST["miembro_id"], $_POST["fecha_prestamo"], $_POST["fecha_devolucion"])) {
            $prestamo_id = intval($_POST["prestamo_id"]);
            $libro_id = $_POST["libro_id"];
            $miembro_id = $_POST["miembro_id"];
            $fecha_prestamo = $_POST["fecha_prestamo"];
            $fecha_devolucion = $_POST["fecha_devolucion"];
            
            $datos = $prestamos->actualizar($prestamo_id, $libro_id, $miembro_id, $fecha_prestamo, $fecha_devolucion);
            if ($datos) {
                $response = [
                    'status' => 'success',
                    'message' => 'Prestamo updated successfully',
                    'data' => $datos
                ];
            }
        } else {
            $response['message'] = 'Missing required fields';
        }
        echo json_encode($response);
        break;

    case 'eliminar':
        if (isset($_POST["prestamo_id"])) {
            $prestamo_id = intval($_POST["prestamo_id"]);
            $datos = $prestamos->eliminar($prestamo_id);
            if ($datos) {
                $response = [
                    'status' => 'success',
                    'message' => 'Prestamo deleted successfully',
                    'data' => $datos
                ];
            }
        } else {
            $response['message'] = 'Missing prestamo_id';
        }
        echo json_encode($response);
        break;
}
?>
