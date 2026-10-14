<?php
require __DIR__ . "/../Datos/Clases/ClassUsuario.php";
require __DIR__ . "/../Datos/Clases/ClassUsuarioextranjero.php";
require_once __DIR__ . "/backend/sanitizar.php";
require_once __DIR__ . "/../Datos/DataBase/ConexionMYSQL/conexion.php";

$pendientesusuario = Usuario::mostrarpendientes($conexion);
$pendientesextranjero = Usuarioextranjero::mostrarpendientes($conexion);
$inactivausuario = Usuario::mostrarinactivos($conexion);
$inactivausuarioextranjero = Usuarioextranjero::mostrarinactivos($conexion);
$rechazadousuario = Usuario::mostrarrechazados($conexion);
$rechazadousuarioextranjero = Usuarioextranjero::mostrarrechazados($conexion);
$todosRechazados = array_merge($rechazadousuario, $rechazadousuarioextranjero);
$todosInactivas = array_merge($inactivausuario, $inactivausuarioextranjero);
$todosPendientes = array_merge($pendientesusuario, $pendientesextranjero);
