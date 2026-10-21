<?php

$moduloRequerido = "inventario";
require_once __DIR__ . "/guardia.php";
require_once __DIR__ . "/sanitizar.php";


require_once '../../Datos/Clases/ClassInventario.php';
require_once '../../Datos/Clases/ClassSalones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $numero_serie = limpiarSerie($_POST['numero_serie'] ?? '');
    $nombre = limpiarTextoCorto($_POST['nombre'] ?? '', 50);
    $marca = limpiarTextoCorto($_POST['marca'] ?? '', 50);
    $modelo = limpiarTextoCorto($_POST['modelo'] ?? '', 50);
    $estado = limpiarOpcion($_POST['estado'] ?? '', ["operativo", "en_reparacion", "de_baja", "prestado"]);
    $id_salon = limpiarEntero($_POST['id_salon'] ?? '');

    $esEdicion = limpiarOpcion($_POST['esEdicion'] ?? '', ["1"]);

    $mensajeError = "";

    if ($numero_serie === "") {
        $mensajeError = "Tenes que ingresar el numero de serie";
    }

    if ($mensajeError === "" && $nombre === "") {
        $mensajeError = "Tenes que ingresar el nombre del equipo";
    }

    if ($mensajeError === "" && $marca === "") {
        $mensajeError = "Tenes que ingresar la marca del equipo";
    }

    if ($mensajeError === "" && $modelo === "") {
        $mensajeError = "Tenes que ingresar el modelo del equipo";
    }

    if ($mensajeError === "" && $estado === "") {
        $mensajeError = "Tenes que seleccionar un estado valido";
    }

    if ($mensajeError === "" && $id_salon === "") {
        $mensajeError = "Tenes que asignar un salon";
    }

    if ($mensajeError === "") {
        $consultaSalon = new Salon($conexion, "", "", $id_salon);

        if (!$consultaSalon->buscarporid($id_salon)) {
            $mensajeError = "El salon seleccionado no existe";
        }
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
