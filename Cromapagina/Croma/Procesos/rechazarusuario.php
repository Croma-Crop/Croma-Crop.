<?php

require __DIR__ . '/../Datos/Clases/ClassUsuario.php';
require __DIR__ . '/../Datos/Clases/ClassUsuarioextranjero.php';
if($_SERVER['REQUEST_METHOD'] === "POST"){
$documento = $_POST['documento'];
$accion = $_POST['accion'];
if($accion === 'rechazar'){
if (ctype_digit($documento)){
$rechazar = new Usuario($conexion, $documento, "", "", "", "", "");

}else{
$rechazar = new Usuarioextranjero($conexion, $documento, "", "", "", "", "");

}
$usuariorechazado = $rechazar->rechazar($documento);
if(!$usuariorechazado){
    header("Location: ../Presentacion/html/admin/index_admin.php?tipo=error&mensaje=" . urlencode("No se pudo rechazar correctamente"));
exit;
}else{
    header("Location: ../Presentacion/html/admin/index_admin.php?tipo=exito&mensaje=" . urlencode("Usuario rechazado correctamente"));
exit;
}


}else{

if (ctype_digit($documento)){
$rechazar = new Usuario($conexion, $documento, "", "", "", "", "");

}else{
    $rechazar = new Usuarioextranjero($conexion, $documento, "", "", "", "", "");

}
$usuariorechazado = $rechazar->borrar($documento);
if(!$usuariorechazado){
    header("Location: ../Presentacion/html/admin/index_admin.php?tipo=error&mensaje=" . urlencode("No se pudo borrar correctamente"));
exit;
}else{
        header("Location: ../Presentacion/html/admin/index_admin.php?tipo=exito&mensaje=" . urlencode("Usuario borrado correctamente"));
exit;
}

}


}






?>