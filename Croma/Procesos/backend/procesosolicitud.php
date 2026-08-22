<?php
require_once '../../Datos/Clases/ClassSolicitud.php';
require_once '../../Datos/DataBase/ConexionMYSQL/conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'];
    $id_salon = $_POST['id_salon'];
    $descripcion = $_POST['descripcion'];

    if ($id_salon === '') {
        header("Location: ../../Presentacion/html/tickets.php?mensaje=" . urlencode("Seleccione un salón.") . "&tipo=error");
        exit;
    }

    $cedulaSolicitante = $_SESSION['usuarioActivo']['documento'] ?? null;

    $solicitud = new Solicitud(
        $conexion,
        null,     
        $tipo,
        $descripcion,
        $id_salon,
        null,       
        "Pendiente"  
    );

    $ok = $solicitud->guardar($cedulaSolicitante);

    if ($ok) {
        header("Location: ../../Presentacion/html/tickets.php?mensaje=" . urlencode("Solicitud registrada correctamente") . "&tipo=exito");
    } else {
        header("Location: ../../Presentacion/html/tickets.php?mensaje=" . urlencode("No se pudo registrar la solicitud") . "&tipo=error");
    }
    exit;
}
?>