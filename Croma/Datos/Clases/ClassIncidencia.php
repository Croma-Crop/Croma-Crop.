<?php
class Incidencia {
Private int $id_incidencia;
Public int $fecha_creacion;
Public String $descripcion;
Public Prioridad $prioridad;
Public String $turno;
Public int $fecha_limite;
private ?Tecnico $tecnico;       
private ?Equipo $equipo;         
private ?RegistroDiario $registroOrigen;

 public function __construct(
        int $idIncidencia,
        string $descripcion,
        ?Tecnico $tecnico = null,
        ?Equipo $equipo = null,
        ?RegistroDiario $registroOrigen = null
    ) {
        $this->idIncidencia = $idIncidencia;
        $this->descripcion = $descripcion;
        $this->estado = 'Pendiente';
        $this->tecnico = $tecnico;
        $this->equipo = $equipo;
        $this->registroOrigen = $registroOrigen;
    }

    public function cambiarEstado(string $nuevoEstado): void { /* ... */ }
    public function asignarFechaLimite(): void { /* ... */ }
    public function cerrarIncidencia(): void { /* ... */ }
}




?>