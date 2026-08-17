<?php
enum Tipo: string {
    case laboratorio;
    case taller;
}

class Salon {
Private int $id_salon;
Public Tipo $tipo;




public function __construct(Tipo $tipo, int $id_salon) {
        $this->tipo = $tipo;
        $this->id_salon = $id_salon;  
    }

}



?>