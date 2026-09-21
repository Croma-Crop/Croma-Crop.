<?php

$moduloRequerido = "salones";
require_once __DIR__ . "/backend/guardia.php";
require_once __DIR__ . "/backend/sanitizar.php";

require_once '../Datos/Clases/ClassSalones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_salon = limpiarEntero($_POST['id_salon'] ?? '');

    if ($id_salon === "") {
        header('Location: ../Presentacion/html/salones.php?mensaje=' . urlencode("Falta el salon a eliminar") . '&tipo=error');
        exit;
    }

    $salon = new Salon($conexion, "", "", $id_salon);

    if (!$salon->buscarporid($id_salon)) {
        header('Location: ../Presentacion/html/salones.php?mensaje=' . urlencode("El salon no existe") . '&tipo=error');
        exit;
    }

    $enUso = $salon->estaEnUso($id_salon);

    if ($enUso !== "") {
        $mensaje = "No se puede eliminar el salon porque todavia tiene " . $enUso . ". Movelos o eliminalos primero.";
        header('Location: ../Presentacion/html/salones.php?mensaje=' . urlencode($mensaje) . '&tipo=error');
        exit;
    }

    $ok = $salon->borrar($id_salon);

    if ($ok) {
        header('Location: ../Presentacion/html/salones.php?mensaje=' . urlencode("Salon eliminado correctamente") . '&tipo=exito');
    } else {
        header('Location: ../Presentacion/html/salones.php?mensaje=' . urlencode("No se pudo eliminar el salon") . '&tipo=error');
    }
    exit;
}
?>
