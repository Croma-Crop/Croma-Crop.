<?php
session_start();
require '../../../Datos/conexion.php';
require '../../../Datos/Clases/GestorEmpleados.php';

header('Content-Type: application/json');

if (!GestorEmpleados::esAdministrador()) {
    http_response_code(403);
    exit(json_encode(['error' => 'No autorizado']));
}

$gestor = new GestorEmpleados($conexion);
exit(json_encode($gestor->listar()));