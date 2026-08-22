<?php
require __DIR__ . '/../DataBase/ConexionMYSQL/conexion.php';

class Solicitud {
    public mysqli $conexion;
    public ?int $id_solicitud;
    public string $tipo;
    public string $descripcion;
    public string $estado;
    public ?int $id_salon;
    public ?string $tecnico;

    public function __construct(
        mysqli $conexion,
        ?int $id_solicitud,
        string $tipo,
        string $descripcion,
        ?int $id_salon,
        ?string $tecnico = null,
        string $estado = 'Pendiente'
    ) {
        $this->conexion = $conexion;
        $this->id_solicitud = $id_solicitud;
        $this->tipo = $tipo;
        $this->descripcion = $descripcion;
        $this->id_salon = $id_salon;
        $this->tecnico = $tecnico;
        $this->estado = $estado;
    }

    public static function mostrar($conexion) {
        $sql = "SELECT id_solicitud, tipo, descripcion, estado, cedula_solicitante, cedula_tecnico, id_espacio
                FROM solicitud";
        $resultado = $conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function guardar($cedulaSolicitante) {
        try {
            $sql = "INSERT INTO solicitud (tipo, descripcion, estado, cedula_solicitante, cedula_tecnico, id_espacio)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);

            if (!$stmt) {
                return false;
            }

            $stmt->bind_param("sssssi", $this->tipo, $this->descripcion, $this->estado, $cedulaSolicitante, $this->tecnico, $this->id_salon);

            return $stmt->execute();

        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }
}