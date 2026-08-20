<?php
session_start();
require '../../../Datos/conexion.php';
require '../../../Datos/Clases/GestorUsuarios.php';

header('Content-Type: application/json');

$gestor = new GestorUsuarios($conexion);
echo json_encode($gestor->guardar($_POST));