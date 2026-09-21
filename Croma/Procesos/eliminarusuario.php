<?php

$moduloRequerido = "administrador";
require_once __DIR__ . "/backend/guardia.php";
require_once __DIR__ . "/backend/sanitizar.php";

require_once '../Datos/Clases/ClassUsuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $documento = limpiarDocumento($_POST['documento'] ?? '');

    if ($documento === "") {
        header('Location: ../Presentacion/html/admin/administrador.php?mensaje=' . urlencode("Falta el documento del empleado") . '&tipo=error');
        exit;
    }

    $miDocumento = $_SESSION['usuarioActivo']['documento'] ?? '';

    if ($documento === $miDocumento) {
        header('Location: ../Presentacion/html/admin/administrador.php?mensaje=' . urlencode("No podes eliminar tu propio usuario") . '&tipo=error');
        exit;
    }

    $usuario = new Usuario($conexion, $documento, "", "", "");
    $ok = $usuario->borrar($documento);

    if ($ok) {
        header('Location: ../Presentacion/html/admin/administrador.php?mensaje=' . urlencode("Usuario borrado correctamente") . '&tipo=exito');
    } else {
        header('Location: ../Presentacion/html/admin/administrador.php?mensaje=' . urlencode("El usuario no fue borrado correctamente") . '&tipo=error');
    }
    exit;
}
?>
