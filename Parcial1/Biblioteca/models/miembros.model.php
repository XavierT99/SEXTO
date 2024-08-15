<?php
require_once('../config/config.php');
class Miembros
{
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `miembros`";
        $stmt = $con->prepare($cadena);
        $stmt->execute();
        $result = $stmt->get_result();
        $con->close();
        return $result;
    }

    public function uno($miembro_id)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `miembros` WHERE `miembro_id` = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param("i", $miembro_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $con->close();
        return $result;
    }

    public function insertar($nombre, $apellido, $email, $fecha_suscripcion)
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "INSERT INTO `miembros` (`nombre`, `apellido`, `email`, `fecha_suscripcion`) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($cadena);
            $stmt->bind_param("ssss", $nombre, $apellido, $email, $fecha_suscripcion);
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

    public function actualizar($miembro_id, $nombre, $apellido, $email, $fecha_suscripcion)
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "UPDATE `miembros` SET `nombre` = ?, `apellido` = ?, `email` = ?, `fecha_suscripcion` = ? WHERE `miembro_id` = ?";
            $stmt = $con->prepare($cadena);
            $stmt->bind_param("sssii", $nombre, $apellido, $email, $fecha_suscripcion, $miembro_id);
            if ($stmt->execute()) {
                return $miembro_id;
            } else {
                return $stmt->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function eliminar($miembro_id)
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "DELETE FROM `miembros` WHERE `miembro_id` = ?";
            $stmt = $con->prepare($cadena);
            $stmt->bind_param("i", $miembro_id);
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
