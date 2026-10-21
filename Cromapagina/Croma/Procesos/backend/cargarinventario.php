<?php

require_once __DIR__ . '/sanitizar.php';
require_once '../../Datos/Clases/ClassSalones.php';
require_once '../../Datos/Clases/ClassInventario.php';

require_once '../../Datos/DataBase/ConexionMYSQL/conexion.php';
require_once '../../Procesos/mostrarticket.php';

$usuario = $_SESSION['usuarioActivo'];

$salones = Salon::mostrar($conexion);

$salonElegido = limpiarEntero($_POST['salon'] ?? $_GET['salon'] ?? '');
$equiposDelSalon = [];

if ($salonElegido !== '') {
    $equipos = new Inventario($conexion , "", "", "", "", "", null, null, null);
    return $equiposDelSalon = $equipos->salonElegido($salonElegido);
}
?>
