<?php

$moduloRequerido = "salones";
require_once __DIR__ . "/guardia.php";

require_once '../../Datos/Clases/ClassSalones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$id_salon = $_POST['id_salon'];
$nombre = $_POST['nombre'];
$tipo = $_POST['tipo'];

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
