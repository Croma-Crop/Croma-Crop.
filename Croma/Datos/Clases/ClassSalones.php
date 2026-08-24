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
    try {
        $sql = "DELETE FROM salon WHERE id_salon = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("i", $id_salon);
        return $stmt->execute();
    } catch (mysqli_sql_exception $e) {
        return registrarErrorBD($e, "Salon");
    }
 }

 public function contarEnTabla($tabla, $id_salon){
    $sql = "SELECT COUNT(*) AS total FROM " . $tabla . " WHERE id_salon = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("i", $id_salon);
    $stmt->execute();
    $fila = $stmt->get_result()->fetch_assoc();
    return (int) $fila['total'];
 }

 public function estaEnUso($id_salon){
    $motivos = [];

    $equipos = $this->contarEnTabla("inventario", $id_salon);
    if ($equipos > 0) {
        $motivos[] = $equipos . " equipo(s) en el inventario";
    }

    $registros = $this->contarEnTabla("registro_diario", $id_salon);
    if ($registros > 0) {
        $motivos[] = $registros . " registro(s) diario(s)";
    }

    $solicitudes = $this->contarEnTabla("solicitud", $id_salon);
    if ($solicitudes > 0) {
        $motivos[] = $solicitudes . " solicitud(es)";
    }

    $texto = "";
    foreach ($motivos as $motivo) {
        if ($texto !== "") {
            $texto = $texto . ", ";
        }
        $texto = $texto . $motivo;
    }

    return $texto;
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