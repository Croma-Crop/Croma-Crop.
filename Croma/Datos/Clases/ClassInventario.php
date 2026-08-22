<?php
require __DIR__ ."/ClassSalones.php";
require __DIR__ . '/../DataBase/ConexionMYSQL/conexion.php';

class Inventario{
 public mysqli $conexion;
public string $numero_serie;
public string $nombre;
public string $marca;
public string $modelo;
public string $estado;
public ?int $id_salon;
public ?string $cedula_administrador;
public ?int $numero_intervenciones;



 public function __construct(mysqli $conexion, string $numero_serie, string $nombre, string $marca, string $modelo, string $estado, ?int $id_salon = null, ?string $cedula_administrador = null, ?int $numero_intervenciones = NULL) {
        $this->conexion = $conexion;
        $this->numero_serie = $numero_serie;
        $this->nombre = $nombre;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->estado = $estado;
        $this->id_salon = $id_salon;
        $this->cedula_administrador = $cedula_administrador;
        $this->numero_intervenciones = $numero_intervenciones;
    }

     public function buscarpornombre($nombre)
    {
    $sql = "SELECT numero_serie, nombre, marca, modelo, estado, id_salon, numero_intervenciones
            FROM inventario 
            WHERE nombre = ?";

    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("s", $nombre);
    $stmt->execute();

    $resultado = $stmt->get_result();

    $inventario = [];

    while ($fila = $resultado->fetch_assoc()) {
        $inventario[] = $fila;
    }

    return $inventario;
}
    

 public static function mostrar(){
    global $conexion;
    $sql = $conexion->query("SELECT tipo, nombre, id_salon FROM salon");
    $sql2 = $conexion->query("SELECT inventario.numero_serie, inventario.nombre, inventario.marca, inventario.modelo, 
               inventario.estado, inventario.numero_intervenciones, inventario.id_salon,
               salon.nombre AS nombre_salon
                FROM inventario
                JOIN salon ON inventario.id_salon = salon.id_salon");
    $salones = $sql->fetch_all(MYSQLI_ASSOC);
    $equipos = $sql2->fetch_all(MYSQLI_ASSOC);
    return [
        "salones" => $salones,
        "equipos" => $equipos
    ];
    

}

 
 public function borrar($numero_serie){
$sql = "DELETE FROM inventario WHERE numero_serie = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("s", $numero_serie);
    return $stmt->execute();
 }

  public function buscarpornumero(string $numero_serie)
{
try {

    $sql = "SELECT marca, modelo, estado, id_salon, nombre, numero_serie
            FROM inventario
            WHERE numero_serie = ?";

    $stmt = $this->conexion->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("s", $numero_serie);

    if (!$stmt->execute()) {
        return false;
    }

    $resultado = $stmt->get_result();

    return $resultado->fetch_assoc();

} catch (mysqli_sql_exception $e) {
    return false;
}

}

 public function modificar($numero_serie) {
    $sql = "UPDATE inventario SET modelo = ?, nombre = ?, marca = ?, estado = ?, id_salon = ? WHERE numero_serie = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("ssssis", $this->modelo, $this->nombre, $this->marca, $this->estado, $this->id_salon, $numero_serie);
    return $stmt->execute();
}
 public function guardar()
{
try {


    $sql = "INSERT INTO inventario
            (numero_serie, modelo, nombre, marca, estado, id_salon)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $this->conexion->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param(
        "sssssi",
        $this->numero_serie,
        $this->modelo,
        $this->nombre,
        $this->marca,
        $this->estado,
        $this->id_salon
    );

    return $stmt->execute();

} catch (mysqli_sql_exception $e) {
    return false;
}


}




}






?>