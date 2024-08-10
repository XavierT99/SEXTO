<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

//TODO: Controlador de productos

require_once('../models/productos.model.php');
error_reporting(0);
$productos = new Productos;

switch ($_GET["op"]) {
    // TODO: Operaciones de productos

    case 'todos': // Procedimiento para cargar todos los datos de los productos
        $datos = array(); 
        $datos = $productos->todos(); 
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno': // Procedimiento para obtener un registro de la base de datos
        if (!isset($_POST["idProductos"])) {
            echo json_encode(["error" => "Product ID not specified."]);
            exit();
        }
        $idProductos = intval($_POST["idProductos"]);
        $datos = array();
        $datos = $productos->uno($idProductos);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar': // Procedimiento para insertar un producto en la base de datos
        if (!isset($_POST["Codigo_Barras"]) || !isset($_POST["Nombre_Producto"]) || !isset($_POST["Graba_IVA"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $Codigo_Barras = $_POST["Codigo_Barras"];
        $Nombre_Producto = $_POST["Nombre_Producto"];
        $Graba_IVA = $_POST["Graba_IVA"];

        $datos = array();
        $datos = $productos->insertar($Codigo_Barras, $Nombre_Producto, $Graba_IVA);
        echo json_encode($datos);
        break;

    case 'actualizar': // Procedimiento para actualizar un producto en la base de datos
        if (!isset($_POST["idProductos"]) || !isset($_POST["Codigo_Barras"]) || !isset($_POST["Nombre_Producto"]) || !isset($_POST["Graba_IVA"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $idProductos = intval($_POST["idProductos"]);
        $Codigo_Barras = $_POST["Codigo_Barras"];
        $Nombre_Producto = $_POST["Nombre_Producto"];
        $Graba_IVA = $_POST["Graba_IVA"];

        $datos = array();
        $datos = $productos->actualizar($idProductos, $Codigo_Barras, $Nombre_Producto, $Graba_IVA);
        echo json_encode($datos);
        break;

    case 'eliminar': // Procedimiento para eliminar un producto en la base de datos
        if (!isset($_POST["idProductos"])) {
            echo json_encode(["error" => "Product ID not specified."]);
            exit();
        }
        $idProductos = intval($_POST["idProductos"]);
        $datos = array();
        $datos = $productos->eliminar($idProductos);
        echo json_encode($datos);
        break;

    default:
        echo json_encode(["error" => "Invalid operation."]);
        break;
}
