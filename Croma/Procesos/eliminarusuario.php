<?php
require_once '../Datos/Clases/ClassUsuario.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$documento = $_POST['documento'];


$usuario = new Usuario($conexion, "11111111", "", "", "");
$ok = $usuario->borrar($documento);


if ($ok) {
    header('Location: ../Presentacion/html/admin/administrador.php?mensaje=Usuario borrado correctamente&tipo=exito');
} else {
    header('Location: ../Presentacion/html/admin/administrador.php?mensaje=Usuario no fue borrado correctamente&tipo=error');
}
exit;
}
?>