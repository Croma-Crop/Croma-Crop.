<?php

$moduloRequerido = "administrador";
require_once __DIR__ . "/backend/guardia.php";

require_once '../Datos/Clases/ClassUsuario.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$documento = $_POST['documento'];


$usuario = new Usuario($conexion, "11111111", "", "", "");
$ok = $usuario->borrar($documento);


if ($ok) {
    header('Location: ../Presentacion/html/admin/administrador.php?mensaje=Usuario borrado correctamente&tipo=exito');
} else {
    $mensaje = $usuario->errorBorrado ?? "Usuario no fue borrado correctamente";
    header('Location: ../Presentacion/html/admin/administrador.php?mensaje=' . urlencode($mensaje) . '&tipo=error');
}
}
?>