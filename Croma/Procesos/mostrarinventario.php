<?php
require __DIR__ . "../../Datos/Clases/ClassInventario.php";
require __DIR__ . "../../Datos/Clases/ClassIntervencion.php";


if($_SERVER['REQUEST_METHOD'] === 'POST'){
$ok = Inventario::mostrar();
$salones = $ok['salones'];
$equipos = $ok['equipos'];


}else{
    $ok = Inventario::mostrar();
    $salones = $ok['salones'];
    $equipos = $ok['equipos'];
    
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