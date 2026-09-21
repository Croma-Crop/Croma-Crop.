<?php
require __DIR__ . "/../Datos/Clases/ClassSalones.php";
require_once __DIR__ . "/backend/sanitizar.php";
require_once __DIR__ . "/../Datos/DataBase/ConexionMYSQL/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombrebusqueda = limpiarTextoCorto($_POST['nombre'] ?? '', 50);

    if ($nombrebusqueda !== '') {
        header("Location: ../Presentacion/html/salones.php?buscar=" . urlencode($nombrebusqueda));
        exit;
    }

    header("Location: ../Presentacion/html/salones.php");
    exit;
}


$nombrebusqueda = limpiarTextoCorto($_GET['buscar'] ?? '', 50);

if ($nombrebusqueda !== '') {

    $tablabusqueda = new Salon($conexion, "", "", "");

    $ok = $tablabusqueda->buscarpornombre($nombrebusqueda);

} else {

    $ok = Salon::mostrar($conexion);
}


$editando = null;
if (isset($_GET['editar'])) {
    $idmodificado = limpiarEntero($_GET['editar']);

    if ($idmodificado !== '') {
        $consulta = new Salon($conexion, "", "", $idmodificado);
        $editando = $consulta->buscarporid($idmodificado);
    }
}



?>
