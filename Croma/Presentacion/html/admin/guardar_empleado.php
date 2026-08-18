<?php
session_start();
require '../../../Datos/conexion.php';
require '../../../Datos/Clases/GestorEmpleados.php';

header('Content-Type: application/json');

if (!GestorEmpleados::esAdministrador()) {
    http_response_code(403);
    exit(json_encode(['error' => 'No autorizado']));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['error' => 'Método no permitido']));
}

$gestor = new GestorEmpleados($conexion);
$resultado = $gestor->guardar($_POST);

if (isset($resultado['error'])) {
    http_response_code($resultado['codigo']);
    exit(json_encode(['error' => $resultado['error']]));
}

exit(json_encode($resultado));