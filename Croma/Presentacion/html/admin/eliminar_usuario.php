<?php
session_start();
require '../../../Datos/conexion.php';
require '../../../Datos/Clases/GestorUsuarios.php';

header('Content-Type: application/json');

$documento = $_POST['documento'] ?? '';
$gestor = new GestorUsuarios($conexion);
echo json_encode($gestor->eliminar($documento));