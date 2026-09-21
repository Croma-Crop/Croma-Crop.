<?php
require __DIR__ . '/../Datos/Clases/ClassUsuario.php';
require_once __DIR__ . '/../Datos/DataBase/ConexionMYSQL/conexion.php';
$usuario = Usuario::mostrar($conexion);


?>
