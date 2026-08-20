<?php
require __DIR__ . "../../Datos/Clases/ClassSalones.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['nombre']) && trim($_POST['nombre']) !== '') {

        $nombrebusqueda = trim($_POST['nombre']);

        header("Location: ../Presentacion/html/salones.php?buscar=" . urlencode($nombrebusqueda));
        exit;
    }

    header("Location: ../Presentacion/html/salones.php");
    exit;
}


if (isset($_GET['buscar']) && trim($_GET['buscar']) !== '') {

    $tablabusqueda = new Salon($conexion, "", "", "");

    $nombrebusqueda = trim($_GET['buscar']);

    $ok = $tablabusqueda->buscarpornombre($nombrebusqueda);

} else {

    $ok = Salon::mostrar();
}


$editando = null;
if (isset($_GET['editar'])) {
    $idmodificado = $_GET['editar'];
    $consulta = new Salon($conexion, "", "", $idmodificado);
    $editando = $consulta->buscarporid($idmodificado);
}



?>
