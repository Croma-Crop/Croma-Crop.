<?php
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
    header("Location: ../../Presentacion/html/salones.php");
} else {
    header("Location: ../../Presentacion/html/salones.php");
}
exit;
}

?>
