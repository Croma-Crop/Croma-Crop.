<?php

$moduloRequerido = "inventario";
require_once __DIR__ . "/guardia.php";


require_once '../../Datos/Clases/ClassInventario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $numero_serie = $_POST['numero_serie'];
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $estado = $_POST['estado'];
    $id_salon = $_POST['id_salon'];
    

    $esEdicion = $_POST['esEdicion'] ?? '';

    $inventario = new Inventario(
        $conexion,
        $numero_serie,
        $nombre,
        $marca,
        $modelo,
        $estado,
        $id_salon,
        null
    );

    if ($esEdicion === '1') {

        $ok = $inventario->modificar($numero_serie);

    } else {

        $ok = $inventario->guardar();

    }

    if ($ok) {
        header("Location: ../../Presentacion/html/inventario.php?mensaje=" . urlencode("Equipo guardado correctamente"));
    } else {
        header("Location: ../../Presentacion/html/inventario.php?mensaje=" . urlencode("No se pudo guardar el equipo"));
    }
    exit;
}

?>



