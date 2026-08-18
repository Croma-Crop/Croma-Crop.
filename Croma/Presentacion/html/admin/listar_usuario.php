<?php
session_start();
require '../../../Datos/conexion.php';
require '../../../Datos/Clases/GestorUsuarios.php';

header('Content-Type: application/json');

if (!GestorUsuarios::esAdministrador()) {
    http_response_code(403);
    exit(json_encode(['error' => 'No autorizado']));
}

$gestor = new GestorUsuarios($conexion);
exit(json_encode($gestor->listar()));