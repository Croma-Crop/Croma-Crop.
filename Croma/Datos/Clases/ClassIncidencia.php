<?php
require __DIR__ . '/../DataBase/ConexionMYSQL/conexion.php';

class Incidencia {
Public mysqli $conexion;
Public ?int $id_incidencia;
Public string $fecha;
Public String $descripcion;
Public String $prioridad;
Public String $turno;
Public ?string $fecha_limite;
Public ?string $tecnico;
Public ?string $cedulaSolicitante;
Public string $estado;


 public function __construct(
        mysqli $conexion,
        ?int $id_incidencia,
        string $fecha,
        string $descripcion,
        string $prioridad,
        string $turno,
        ?string $fecha_limite,
        ?String $tecnico,
        ?string $cedulaSolicitante,
        string $estado = 'Pendiente'
    ) {
        $this->conexion = $conexion;
        $this->id_incidencia = $id_incidencia;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->prioridad = $prioridad;
        $this->turno = $turno;
        $this->tecnico = $tecnico;
        $this->cedulaSolicitante = $cedulaSolicitante;
        $this->estado = $estado;
      
    }
    public static function mostrar($conexion) {
    $sql = "SELECT 'Incidencia' AS clase, id_incidencia AS id, fecha, fecha_limite, turno, estado, tipo, descripcion, prioridad, cedula_solicitante, cedula_tecnico
        FROM incidencia
        UNION ALL
        SELECT 'Solicitud' AS clase, id_solicitud AS id, NULL AS fecha, NULL AS fecha_limite, NULL AS turno, estado, tipo, descripcion, NULL AS prioridad, cedula_solicitante, cedula_tecnico
        FROM solicitud
        ORDER BY fecha DESC";
    $resultado = $conexion->query($sql);
    return $resultado->fetch_all(MYSQLI_ASSOC);
}
public function guardar($cedulaSolicitante, $tipo) {
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




?>