<?php
require __DIR__ .'/../DataBase/ConexionMYSQL/conexion.php'; 
class Ficha {
public mysqli $conexion;
public ?int $id_registro;
public string $fecha;
public string $hora_entrada;
public string $hora_salida;
public string $cedula_solicitante;
public int $id_salon;

public function __construct(
        mysqli $conexion,
        ?int $id_registro,
        string $fecha,
        string $hora_entrada,
        string $hora_salida,
        string $cedula_solicitante,
        int $id_salon
       
        
    ) {
        $this->conexion = $conexion;
        $this->id_registro = $id_registro;
        $this->fecha = $fecha;
        $this->hora_entrada = $hora_entrada;
        $this->hora_salida = $hora_salida;
        $this->cedula_solicitante = $cedula_solicitante;
        $this->id_salon = $id_salon;
       
    }
   
    public function guardar(): bool {
    try {
        $sql = "INSERT INTO registro_diario (fecha, hora_entrada, hora_salida, cedula_solicitante, id_salon) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssssi", $this->fecha, $this->hora_entrada, $this->hora_salida, $this->cedula_solicitante, $this->id_salon);

        if (!$stmt->execute()) {
            return false;
        }

        $this->id_registro = $stmt->insert_id;

        return true;

    } catch (mysqli_sql_exception $e) {
        return false;
    }
}


}






?>