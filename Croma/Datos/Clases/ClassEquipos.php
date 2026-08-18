<?php



class Equipo {
public String $marca;
private String $numero_serie;
public String $modelo;




 public function __construct(String $marca, String $numero_serie, String $modelo) {
        $this->numero_serie = $numero_serie;
        $this->marca = $marca;  
        $this->modelo = $modelo;
    }

}








?>