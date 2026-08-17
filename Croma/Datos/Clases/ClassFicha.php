<?php
class Ficha {
private int $id_registro;
public int $fecha;
public int $hora_inicio;
public int $hora_fin;
public ?Documento_Solicitante $documento_solicitante;
private ?Id_Salon $id_salon;

public function __construct(
        int $id_registro,
        int $fecha,
        int $hora_inicio,
        int $hora_fin,
        ?Documento_Solicitante $documento_solicitante = null,
        ?Id_Salon $id_salon = null,
        
    ) {
        $this->id_registro = $id_registro;
        $this->fecha = $fecha;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
        $this->documento_solicitante = $documento_solicitante;
        $this->id_salon = $id_salon;
    }


}






?>