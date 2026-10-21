<?php
require __DIR__ . '/../Datos/Clases/ClassUsuario.php';
require __DIR__ . '/../Datos/Clases/ClassUsuarioextranjero.php';

require_once __DIR__ . '/../Datos/DataBase/ConexionMYSQL/conexion.php';
$usuario = Usuario::mostraractivos($conexion);
$usuarioextranjero = Usuarioextranjero::mostraractivos($conexion);
$todos = array_merge($usuario, $usuarioextranjero);
?>
