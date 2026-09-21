<?php

require_once __DIR__ . '/sanitizar.php';
require_once '../../Datos/Clases/ClassSalones.php';
require_once '../../Datos/DataBase/ConexionMYSQL/conexion.php';
require_once '../../Procesos/mostrarticket.php';

$usuario = $_SESSION['usuarioActivo'];

$salones = Salon::mostrar($conexion);

$salonElegido = limpiarEntero($_POST['salon'] ?? $_GET['salon'] ?? '');
$equiposDelSalon = [];

if ($salonElegido !== '') {
    $sql = $conexion->prepare("SELECT numero_serie, nombre FROM inventario WHERE id_salon = ? AND estado <> 'de_baja'");
    $sql->bind_param("i", $salonElegido);
    $sql->execute();
    $equiposDelSalon = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>
