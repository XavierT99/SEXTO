<?php
require_once('../config/config.php');
class Prestamos
{
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `prestamos`";
        $stmt = $con->prepare($cadena);
        $stmt->execute();
        $result = $stmt->get_result();
        $con->close();
        return $result;
    }

    public function uno($prestamo_id)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `prestamos` WHERE `prestamo_id` = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param("i", $prestamo_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $con->close();
        return $result;
    }

    public function insertar($libro_id, $miembro_id, $fecha_prestamo, $fecha_devolucion)
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "INSERT INTO `prestamos` (`libro_id`, `miembro_id`, `fecha_prestamo`, `fecha_devolucion`) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($cadena);
            $stmt->bind_param("iiss", $libro_id, $miembro_id, $fecha_prestamo, $fecha_devolucion);
            if ($stmt->execute()) {
                return $con->insert_id;
            } else {
                return $stmt->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function actualizar($prestamo_id, $libro_id, $miembro_id, $fecha_prestamo, $fecha_devolucion)
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "UPDATE `prestamos` SET `libro_id` = ?, `miembro_id` = ?, `fecha_prestamo` = ?, `fecha_devolucion` = ? WHERE `prestamo_id` = ?";
            $stmt = $con->prepare($cadena);
            $stmt->bind_param("iissi", $libro_id, $miembro_id, $fecha_prestamo, $fecha_devolucion, $prestamo_id);
            if ($stmt->execute()) {
                return $prestamo_id;
            } else {
                return $stmt->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function eliminar($prestamo_id)
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "DELETE FROM `prestamos` WHERE `prestamo_id` = ?";
            $stmt = $con->prepare($cadena);
            $stmt->bind_param("i", $prestamo_id);
            if ($stmt->execute()) {
                return 1;
            } else {
                return $stmt->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }
}
?>
