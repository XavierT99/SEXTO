<?php
require_once('../config/config.php');
class Libros
{
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `libros`";
        $stmt = $con->prepare($cadena);
        $stmt->execute();
        $result = $stmt->get_result();
        $con->close();
        return $result;
    }

    public function uno($libro_id)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `libros` WHERE `libro_id` = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param("i", $libro_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $con->close();
        return $result;
    }

    public function insertar($titulo, $autor, $genero, $anio_publicacion)
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "INSERT INTO `libros` (`titulo`, `autor`, `genero`, `anio_publicacion`) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($cadena);
            $stmt->bind_param("sssi", $titulo, $autor, $genero, $anio_publicacion);
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

    public function actualizar($libro_id, $titulo, $autor, $genero, $anio_publicacion)
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "UPDATE `libros` SET `titulo` = ?, `autor` = ?, `genero` = ?, `anio_publicacion` = ? WHERE `libro_id` = ?";
            $stmt = $con->prepare($cadena);
            $stmt->bind_param("sssii", $titulo, $autor, $genero, $anio_publicacion, $libro_id);
            if ($stmt->execute()) {
                return $libro_id;
            } else {
                return $stmt->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function eliminar($libro_id)
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "DELETE FROM `libros` WHERE `libro_id` = ?";
            $stmt = $con->prepare($cadena);
            $stmt->bind_param("i", $libro_id);
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
