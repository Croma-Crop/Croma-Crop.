<?php
require_once "ClassSalones.php";
enum Estado: string {
    case Operativo = 'operativo';
    case EnReparacion = 'en_reparacion';
    case DeBaja = 'de_baja';
    case Prestado = 'prestado';
}

class Equipo {
public String $marca;
private String $numero_serie;
public String $modelo;
public Estado $estado;
private ?Salon $salon;



 public function __construct(Estado $estado, String $marca, String $numero_serie, String $modelo) {
        $this->estado = $estado;
        $this->marca = $marca;  
    }
    public function getSalon(): ?Salon {
        return $this->salon;
    }

    public function setSalon(?Salon $salon): void {
        $this->salon = $salon;
    }
}








?>