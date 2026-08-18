<?php
require '../../Datos/DataBase/ConexionMYSQL/conexion.php';

class Salon {
Public mysqli $conexion;
Public String $tipo;
Public String $nombre;



public function __construct(mysqli $conexion, String $tipo, String $nombre) {
        $this->conexion = $conexion;
        $this->tipo = $tipo;
        $this->nombre = $nombre;
    }


 public function guardar(): bool
{
    try {
        $sql = "INSERT INTO salon (tipo, nombre) VALUES (?, ?)";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ss", $this->tipo, $this->nombre);

        if (!$stmt->execute()) {
            return false;
        }

        return true;

    } catch (mysqli_sql_exception $e) {
        return false;
    }
}
}



?>