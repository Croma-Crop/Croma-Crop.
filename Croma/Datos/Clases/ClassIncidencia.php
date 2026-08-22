<?php
require __DIR__ . '/../DataBase/ConexionMYSQL/conexion.php';

class Incidencia {
    public mysqli $conexion;
    public ?int $id_incidencia;
    public string $fecha;
    public string $descripcion;
    public string $prioridad;
    public string $turno;
    public ?string $fecha_limite;
    public ?string $tecnico;
    public string $estado;

    public function __construct(
        mysqli $conexion,
        ?int $id_incidencia,
        string $fecha,
        string $descripcion,
        string $prioridad,
        string $turno,
        ?string $fecha_limite,
        ?string $tecnico,
        string $estado = 'Pendiente'
    ) {
        $this->conexion = $conexion;
        $this->id_incidencia = $id_incidencia;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->prioridad = $prioridad;
        $this->turno = $turno;
        $this->fecha_limite = $fecha_limite;
        $this->tecnico = $tecnico;
        $this->estado = $estado;
    }

    public static function mostrar($conexion) {
        $sql = "SELECT id_incidencia, fecha, fecha_limite, turno, estado, tipo, descripcion, prioridad, cedula_solicitante, cedula_tecnico
                FROM incidencia
                ORDER BY fecha DESC";
        $resultado = $conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function guardar($tipo, $cedulaSolicitante) {
        try {
            $sql = "INSERT INTO incidencia (fecha, fecha_limite, turno, estado, tipo, descripcion, prioridad, cedula_solicitante, cedula_tecnico)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);

            if (!$stmt) {
                return false;
            }

            $stmt->bind_param("sssssssss", $this->fecha, $this->fecha_limite, $this->turno, $this->estado, $tipo, $this->descripcion, $this->prioridad, $cedulaSolicitante, $this->tecnico);

            return $stmt->execute();

        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function cambiarEstado(string $nuevoEstado): void { /* ... */ }
    public function asignarFechaLimite(): void { /* ... */ }
    public function cerrarIncidencia(): void { /* ... */ }
}