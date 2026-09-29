<?php


require_once __DIR__ . '/../Datos/Clases/ClassSalones.php';
require_once __DIR__ . '/../Datos/Clases/ClassInventario.php';
require_once __DIR__ . '/../Datos/Clases/ClassUsuario.php';
require_once __DIR__ . '/../Datos/DataBase/ConexionMYSQL/conexion.php';

$salones = Salon::mostrar($conexion);
$profesores = 
$datosInventario = Inventario::mostrar($conexion);
$equipos = $datosInventario['equipos'];
$profesores = Usuario::mostrarsolicitantes($conexion);

?>