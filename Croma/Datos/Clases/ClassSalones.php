<?php

require_once __DIR__ . "/../DataBase/ErroresBD.php";


require_once __DIR__ . '/../DataBase/ConexionMYSQL/conexion.php';
class Salon {
Public mysqli $conexion;
Public String $tipo;
Public String $nombre;
Public String $id_salon;



public function __construct(mysqli $conexion, String $tipo, String $nombre, String $id_salon) {
        $this->conexion = $conexion;
        $this->tipo = $tipo;
        $this->nombre = $nombre;
        $this->id_salon = $id_salon;
    }

 public static function mostrar(){
    global $conexion;
    $sql = $conexion->query("SELECT tipo, nombre, id_salon FROM salon");
    $salones = [];
    while ($fila = $sql->fetch_assoc()) {
    $salones[] = $fila;
    

}
return $salones;
 }
 
 
 public function buscarpornombre($nombre)
{
    $sql = "SELECT tipo, nombre, id_salon 
            FROM salon 
            WHERE nombre = ?";

    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("s", $nombre);
    $stmt->execute();

    $resultado = $stmt->get_result();

    $salones = [];

    while ($fila = $resultado->fetch_assoc()) {
        $salones[] = $fila;
    }

    return $salones;
}
 
 public function borrar($id_salon){
     $sql = "DELETE FROM salon WHERE id_salon = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("i", $id_salon);
    return $stmt->execute();
 }
 public function buscarporid($id_salon){
    try{
    $sql = "SELECT tipo, nombre, id_salon FROM salon WHERE id_salon = ? ";
    $stmt = $this->conexion->prepare($sql);
    if (!$stmt){
        return false;
    }
        $stmt->bind_param("i", $id_salon);
    if (!$stmt->execute()){
        return false;
    }
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
    } catch (mysqli_sql_exception $e) {
        return registrarErrorBD($e, "Salon");
    }
 }
 public function modificar($id_salon) {
    $sql = "UPDATE salon SET tipo = ?, nombre = ? WHERE id_salon = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("ssi", $this->tipo, $this->nombre, $id_salon);
    return $stmt->execute();
}

 public function guardar(): bool {
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
        return registrarErrorBD($e, "Salon");
    }
}
}



?>