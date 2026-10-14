<?php

$moduloRequerido = "administrador";
require_once __DIR__ . "/backend/guardia.php";
require_once __DIR__ . "/backend/sanitizar.php";

require_once '../Datos/Clases/ClassUsuario.php';
require_once '../Datos/Clases/ClassUsuarioextranjero.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $documento = limpiarDocumento($_POST['documento'] ?? '');

    if ($documento === "") {
        header('Location: ../Presentacion/html/admin/administrador.php?mensaje=' . urlencode("Falta el documento del empleado") . '&tipo=error');
        exit;
    }

    $miDocumento = $_SESSION['usuarioActivo']['documento'] ?? '';

    if ($documento === $miDocumento) {
        header('Location: ../Presentacion/html/admin/administrador.php?mensaje=' . urlencode("No podes dar de baja tu propio usuario") . '&tipo=error');
        exit;
    }

    if (usuarioextranjero::existe($conexion, $documento)) {
        $usuario = new usuarioextranjero($conexion, $documento, "", "", "", "",'inactivo');
    } else {
        $usuario = new Usuario($conexion, $documento, "", "", "", "", 'inactivo');
    }
        $ok = $usuario->baja($documento);

    if ($ok) {
        header('Location: ../Presentacion/html/admin/administrador.php?mensaje=' . urlencode("Usuario dado de baja correctamente") . '&tipo=exito');
    } else {
        header('Location: ../Presentacion/html/admin/administrador.php?mensaje=' . urlencode("El usuario no fue dado de baja correctamente") . '&tipo=error');
    }
    exit;
}
?>
