<?php
require __DIR__ . "/../Datos/Clases/ClassUsuario.php";
require __DIR__ . "/../Datos/Clases/ClassUsuarioextranjero.php";
require_once __DIR__ . "/../Datos/DataBase/ConexionMYSQL/conexion.php";

$documento = $_POST['documento'];
if (ctype_digit($documento)){
$aprobar = new Usuario($conexion, $documento, "", "", "", "", "");
}else{
$aprobar = new Usuarioextranjero($conexion, $documento, "", "", "", "", "");
}
$aprobado = $aprobar->aprobar($documento);
if(!$aprobado){
header("Location: ../../Croma/Presentacion/html/admin/index_admin.php?tipo=error&mensaje=" . urlencode("No se pudo aprobar correctamente"));
}else{
header("Location: ../../Croma/Presentacion/html/admin/index_admin.php?tipo=exito&mensaje=" . urlencode("Aprobado correctamente"));
}
exit;










?>