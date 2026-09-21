<?php

$moduloRequerido = "salones";
require_once __DIR__ . "/guardia.php";
require_once __DIR__ . "/sanitizar.php";

require_once '../../Datos/Clases/ClassSalones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$id_salon = limpiarEntero($_POST['id_salon'] ?? '');
$nombre = limpiarTextoCorto($_POST['nombre'] ?? '', 50);
$tipo = limpiarOpcion($_POST['tipo'] ?? '', ["taller", "laboratorio"]);

$mensajeError = "";

if ($nombre === "") {
    $mensajeError = "Tenes que ingresar el codigo del salon";
}

if ($mensajeError === "" && $tipo === "") {
    $mensajeError = "Tenes que seleccionar un tipo de salon";
}

if ($mensajeError !== "") {
    header("Location: ../../Presentacion/html/salones.php?tipo=error&mensaje=" . urlencode($mensajeError));
    exit;
}

$salon = new Salon($conexion, $tipo, $nombre, $id_salon);

if ($id_salon !== '') {
    $ok = $salon->modificar($id_salon);
} else {
    $ok = $salon->guardar();
}

if ($ok) {
    header("Location: ../../Presentacion/html/salones.php?tipo=exito&mensaje=" . urlencode("Salon guardado correctamente"));
} else {
    header("Location: ../../Presentacion/html/salones.php?tipo=error&mensaje=" . urlencode("No se pudo guardar el salon"));
}
exit;
}

?>
