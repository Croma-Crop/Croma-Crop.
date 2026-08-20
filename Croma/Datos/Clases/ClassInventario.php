<?php
require "ClassSalones.php";
require __DIR__ . '/../DataBase/ConexionMYSQL/conexion.php';

class Inventario extends Salon {
public String $marca;
public String $numero_serie;
public String $modelo;




 public function __construct(String $marca, String $numero_serie, String $modelo) {
        $this->numero_serie = $numero_serie;
        $this->marca = $marca;  
        $this->modelo = $modelo;
    }

 public function mostrar(){

 }
 public function borrar(){

 }
 public function modificar(){

 }
 public function guardar(){

 }



}






?>