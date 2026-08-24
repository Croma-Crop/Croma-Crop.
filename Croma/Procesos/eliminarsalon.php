<?php

$moduloRequerido = "salones";
require_once __DIR__ . "/backend/guardia.php";

require_once '../Datos/Clases/ClassSalones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_salon = $_POST['id_salon'];

    $salon = new Salon($conexion, "", "", $id_salon);

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
