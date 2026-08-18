<?php
class Incidencia {
Private int $id_incidencia;
Public int $fecha_creacion;
Public String $descripcion;
Public String $prioridad;
Public String $turno;
Public int $fecha_limite;


 public function __construct(
        int $idIncidencia,
        string $descripcion,
        String $tecnico,
    ) {
        $this->idIncidencia = $idIncidencia;
        $this->descripcion = $descripcion;
        $this->fecha_creacion = $fecha_creacion;
      
    }

    public function cambiarEstado(string $nuevoEstado): void { /* ... */ }
    public function asignarFechaLimite(): void { /* ... */ }
    public function cerrarIncidencia(): void { /* ... */ }
}




?>