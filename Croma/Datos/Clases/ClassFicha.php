<?php
class Ficha {
private int $id_registro;
public int $fecha;
public int $hora_inicio;
public int $hora_fin;


public function __construct(
        int $id_registro,
        int $fecha,
        int $hora_inicio,
        int $hora_fin,
       
        
    ) {
        $this->id_registro = $id_registro;
        $this->fecha = $fecha;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
       
    }


}






?>