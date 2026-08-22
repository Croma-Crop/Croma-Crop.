<?php
require __DIR__ . "../../Datos/Clases/ClassIncidencia.php";
require __DIR__ . "../../Datos/Clases/ClassIntervencion.php";


if($_SERVER['REQUEST_METHOD'] === 'POST'){
$ok = Incidencia::mostrar();

}else{
    $ok = Incidencia::mostrar();

}
$historial = [];
$numeroSerieHistorial = null;

if (isset($_GET['historial'])) {
    $numeroSerieHistorial = $_GET['historial'];
    $historial = Intervencion::mostrarPorEquipo($numeroSerieHistorial, $conexion);
}

if (isset($_GET['buscar']) && trim($_GET['buscar']) !== '') {

    $nombrebusqueda = trim($_GET['buscar']);

    $tablabusqueda = new Inventario($conexion, "", "", "", "", "", null);

    $equipos = $tablabusqueda->buscarpornombre($nombrebusqueda);
}

$editando = null;

if (isset($_GET['editar'])) {

    $nombremodificado = $_GET['editar'];

    $consulta = new Inventario($conexion, "", $nombremodificado, "", "", "", null);
    $editando = $consulta->buscarpornumero($nombremodificado);

    if ($editando) {
        $id_salon = $editando['id_salon'];
    }
}


?>