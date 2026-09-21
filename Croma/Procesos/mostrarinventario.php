<?php
require __DIR__ . "/../Datos/Clases/ClassInventario.php";
require __DIR__ . "/../Datos/Clases/ClassIntervencion.php";
require_once __DIR__ . "/../Datos/DataBase/ConexionMYSQL/conexion.php";
require_once __DIR__ . "/backend/sanitizar.php";


$ok = Inventario::mostrar($conexion);
$salones = $ok['salones'];
$equipos = $ok['equipos'];

$viendoBaja = isset($_GET['baja']);

if ($viendoBaja) {
    $equipos = Inventario::mostrarDadosDeBaja($conexion);
}

$historial = [];
$numeroSerieHistorial = null;

if (isset($_GET['historial'])) {
    $serieBuscada = limpiarSerie($_GET['historial']);

    if ($serieBuscada !== '') {
        $numeroSerieHistorial = $serieBuscada;
        $historial = Intervencion::mostrarPorEquipo($numeroSerieHistorial, $conexion);
    }
}

if (isset($_GET['buscar'])) {

    $nombrebusqueda = limpiarTextoCorto($_GET['buscar'], 50);

    if ($nombrebusqueda !== '') {
        $tablabusqueda = new Inventario($conexion, "", "", "", "", "", null);
        $equipos = $tablabusqueda->buscarpornombre($nombrebusqueda);
    }
}

$editando = null;

if (isset($_GET['editar'])) {

    $nombremodificado = limpiarSerie($_GET['editar']);

    if ($nombremodificado !== '') {
        $consulta = new Inventario($conexion, "", $nombremodificado, "", "", "", null);
        $editando = $consulta->buscarpornumero($nombremodificado);
    }

    if ($editando) {
        $id_salon = $editando['id_salon'];
    }
}


?>
