<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

require_once('../models/libros.model.php');
error_reporting(0);
$libros = new Libros();

$response = [
    'status' => 'error',
    'message' => 'Invalid operation',
    'data' => null
];

switch ($_GET["op"]) {
    case 'todos':
        $datos = $libros->todos();
        $librosArray = [];
        while ($row = mysqli_fetch_assoc($datos)) {
            $librosArray[] = $row;
        }
        if (count($librosArray) > 0) {
            $response = [
                'status' => 'success',
                'message' => 'Libros retrieved successfully',
                'data' => $librosArray
            ];
        }
        echo json_encode($response);
        break;

    case 'uno':
        if (isset($_POST["libro_id"])) {
            $libro_id = intval($_POST["libro_id"]);
            $datos = $libros->uno($libro_id);
            $libro = mysqli_fetch_assoc($datos);
            if ($libro) {
                $response = [
                    'status' => 'success',
                    'message' => 'Libro retrieved successfully',
                    'data' => $libro
                ];
            }
        } else {
            $response['message'] = 'Missing libro_id';
        }
        echo json_encode($response);
        break;

    case 'insertar':
        if (isset($_POST["titulo"], $_POST["autor"], $_POST["genero"], $_POST["anio_publicacion"])) {
            $titulo = $_POST["titulo"];
            $autor = $_POST["autor"];
            $genero = $_POST["genero"];
            $anio_publicacion = $_POST["anio_publicacion"];
            
            $datos = $libros->insertar($titulo, $autor, $genero, $anio_publicacion);
            if ($datos) {
                $response = [
                    'status' => 'success',
                    'message' => 'Libro inserted successfully',
                    'data' => $datos
                ];
            }
        } else {
            $response['message'] = 'Missing required fields';
        }
        echo json_encode($response);
        break;

    case 'actualizar':
        if (isset($_POST["libro_id"], $_POST["titulo"], $_POST["autor"], $_POST["genero"], $_POST["anio_publicacion"])) {
            $libro_id = intval($_POST["libro_id"]);
            $titulo = $_POST["titulo"];
            $autor = $_POST["autor"];
            $genero = $_POST["genero"];
            $anio_publicacion = $_POST["anio_publicacion"];
            
            $datos = $libros->actualizar($libro_id, $titulo, $autor, $genero, $anio_publicacion);
            if ($datos) {
                $response = [
                    'status' => 'success',
                    'message' => 'Libro updated successfully',
                    'data' => $datos
                ];
            }
        } else {
            $response['message'] = 'Missing required fields';
        }
        echo json_encode($response);
        break;

    case 'eliminar':
        if (isset($_POST["libro_id"])) {
            $libro_id = intval($_POST["libro_id"]);
            $datos = $libros->eliminar($libro_id);
            if ($datos) {
                $response = [
                    'status' => 'success',
                    'message' => 'Libro deleted successfully',
                    'data' => $datos
                ];
            }
        } else {
            $response['message'] = 'Missing libro_id';
        }
        echo json_encode($response);
        break;
}
