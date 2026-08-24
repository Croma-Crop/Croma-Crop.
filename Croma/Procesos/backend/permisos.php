<?php
$scriptPath = $_SERVER['SCRIPT_NAME'];
$posicion = strpos($scriptPath, '/Presentacion/');
$BASE_URL = substr($scriptPath, 0, $posicion);

$modulos = [
    "inventario"     => ["etiqueta" => "Inventario", "ruta" => $BASE_URL . "/Presentacion/html/inventario.php"],
    "salones"        => ["etiqueta" => "Salones", "ruta" => $BASE_URL . "/Presentacion/html/salones.php"],
    "tickets"        => ["etiqueta" => "Tickets", "ruta" => $BASE_URL . "/Presentacion/html/tickets.php"],
    "incidenciascreadas"    => ["etiqueta" => "Tickets Creados", "ruta" => $BASE_URL . "/Presentacion/html/incidenciascreadas.php"],
    "ficha"          => ["etiqueta" => "Ficha", "ruta" => $BASE_URL . "/Presentacion/html/usuario/ficha.php"],
    "administrador"  => ["etiqueta" => "Administrador", "ruta" => $BASE_URL ."/Presentacion/html/admin/administrador.php"],
    "kanban" => ["etiqueta" => "Tablero Kanban", "ruta" => $BASE_URL ."/Presentacion/html/tecnico/kanban.php"]
];

$permisos = [
    "administrador"       => ["index_admin", "inventario", "salones", "tickets", "incidenciascreadas", "ficha", "administrador", "kanban"],
    "tecnico"     => ["index_tecnico", "inventario", "salones", "tickets", "incidenciascreadas", "kanban"],
    "solicitante" => ["index_user", "tickets", "incidenciascreadas", "ficha"]
];

$acciones = [
    "eliminarTickets"  => ["administrador", "tecnico"],
    "asignarPrioridad" => ["tecnico"]
];

$InicioPorRol = [
    "administrador"       => $BASE_URL ."/Presentacion/html/admin/index_admin.php",
    "tecnico"     => $BASE_URL ."/Presentacion/html/tecnico/index_tecnico.php",
    "solicitante" => $BASE_URL ."/Presentacion/html/usuario/index_user.php"
];

function tienePermiso($rol, $modulo){
global $permisos;
if (!isset($permisos[$rol])) {
    return false;
}
    return in_array($modulo, $permisos[$rol]);
}
function puedeHacer($accion, $rol){
global $acciones;
if ($rol === "administrador") {
    return true;
}
if (!isset($acciones[$accion])) {
    return false;
}
    return in_array($rol, $acciones[$accion]);

}







?>