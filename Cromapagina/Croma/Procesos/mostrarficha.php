<?php


require_once __DIR__ . '/../Datos/Clases/ClassSalones.php';
require_once __DIR__ . '/../Datos/Clases/ClassInventario.php';
require_once __DIR__ . '/../Datos/Clases/ClassUsuario.php';
require_once __DIR__ . '/../Datos/Clases/ClassUsuarioextranjero.php';
require_once __DIR__ . '/../Datos/DataBase/ConexionMYSQL/conexion.php';

$salones = Salon::mostrar($conexion);
$datosInventario = Inventario::mostrar($conexion);
$equipos = $datosInventario['equipos'];
$profesoresextranjeros = Usuarioextranjero::mostrarsolicitantes($conexion);
$profesores = Usuario::mostrarsolicitantes($conexion);
$todos = array_merge($profesores, $profesoresextranjeros);


?>