<?php

require_once __DIR__ . "/../DataBase/ErroresBD.php";




require_once __DIR__ . '/../DataBase/ConexionMYSQL/conexion.php';

class Intervencion {
    public mysqli $conexion;
    public string $numero_serie;
    public string $fecha;
    public string $descripcion;
    public ?string $tecnico;
    public ?string $solucion;

    public function __construct(mysqli $conexion, string $numero_serie, string $fecha, string $descripcion, ?string $tecnico = null, ?string $solucion = null) {
        $this->conexion = $conexion;
        $this->numero_serie = $numero_serie;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->tecnico = $tecnico;
        $this->solucion = $solucion;
    }

    public function registrar() {
        try {
            $sql = "INSERT INTO intervencion (numero_serie, fecha, descripcion, tecnico, solucion) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);

            if (!$stmt) {
                return false;
            }

            $stmt->bind_param("sssss", $this->numero_serie, $this->fecha, $this->descripcion, $this->tecnico, $this->solucion);

            if (!$stmt->execute()) {
                return false;
            }

            $sqlContador = "UPDATE inventario SET numero_intervenciones = numero_intervenciones + 1 WHERE numero_serie = ?";
            $stmtContador = $this->conexion->prepare($sqlContador);
            $stmtContador->bind_param("s", $this->numero_serie);
            $stmtContador->execute();

            return true;

        } catch (mysqli_sql_exception $e) {
            return registrarErrorBD($e, "Intervencion");
        }
    }

    public static function mostrarPorEquipo($numero_serie, $conexion) {
        $sql = "SELECT fecha, descripcion, tecnico, solucion FROM intervencion WHERE numero_serie = ? ORDER BY fecha DESC";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $numero_serie);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}


?>