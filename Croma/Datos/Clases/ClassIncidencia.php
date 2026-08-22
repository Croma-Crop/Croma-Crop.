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
        string $estado = 'Pendiente'
    ) {
        $this->conexion = $conexion;
        $this->id_incidencia = $id_incidencia;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->prioridad = $prioridad;
        $this->turno = $turno;
        $this->tecnico = $tecnico;
        $this->estado = $estado;
      
    }

    public function cambiarEstado(string $nuevoEstado): void { /* ... */ }
    public function asignarFechaLimite(): void { /* ... */ }
    public function cerrarIncidencia(): void { /* ... */ }
}




?>