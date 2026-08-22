<?php

$moduloRequerido = "inventario";
require_once __DIR__ . "/backend/guardia.php";

require_once '../Datos/Clases/ClassInventario.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$numero_serie = $_POST['numero_serie'];


$inventario = new Inventario($conexion, $numero_serie, "", "", "", "", NULL, NULL);
$ok = $inventario->borrar($numero_serie);


if ($ok) {
    header('Location: ../Presentacion/html/inventario.php?mensaje=Salon guardado correctamente&tipo=exito');
} else {
    header('Location: ../Presentacion/html/inventario.php?mensaje=Salon no fue guardado correctamente&tipo=error');
}
exit;
}

?>
