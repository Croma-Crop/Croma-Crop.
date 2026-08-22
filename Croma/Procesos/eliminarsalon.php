<?php

$moduloRequerido = "salones";
require_once __DIR__ . "/backend/guardia.php";

require_once '../Datos/Clases/ClassSalones.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$id_salon = $_POST['id_salon'];


$salon = new Salon($conexion, "", "", $id_salon);
$ok = $salon->borrar($id_salon);


if ($ok) {
    header('Location: ../Presentacion/html/salones.php?mensaje=Salon guardado correctamente&tipo=exito');
} else {
    header('Location: ../Presentacion/html/salones.php?mensaje=Salon no fue guardado correctamente&tipo=error');
}
exit;
}

?>
