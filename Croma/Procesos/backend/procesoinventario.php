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

    $mensajeError = "";

    if ($id_salon === "") {
        $mensajeError = "Tenes que asignar un salon";
    }

    if ($mensajeError === "" && $esEdicion !== '1') {
        $consulta = $conexion->prepare("SELECT numero_serie FROM inventario WHERE numero_serie = ?");
        $consulta->bind_param("s", $numero_serie);
        $consulta->execute();

        if ($consulta->get_result()->num_rows > 0) {
            $mensajeError = "Ya existe un equipo con el numero de serie " . $numero_serie;
        }
    }

    if ($mensajeError !== "") {
        header("Location: ../../Presentacion/html/inventario.php?tipo=error&mensaje=" . urlencode($mensajeError));
        exit;
    }

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
        header("Location: ../../Presentacion/html/inventario.php?tipo=exito&mensaje=" . urlencode("Equipo guardado correctamente"));
    } else {
        header("Location: ../../Presentacion/html/inventario.php?tipo=error&mensaje=" . urlencode("No se pudo guardar el equipo"));
    }
    exit;
}

?>



