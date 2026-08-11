<?php
$modulos = [
    "inventario"     => ["etiqueta" => "Inventario", "ruta" => "/Croma/Presentacion/html/inventario.php"],
    "salones"        => ["etiqueta" => "Salones", "ruta" => "/Croma/Presentacion/html/salones.php"],
    "tickets"        => ["etiqueta" => "Tickets", "ruta" => "/Croma/Presentacion/html/tickets.php"],
    "incidenciascreadas"    => ["etiqueta" => "Incidencias Creadas", "ruta" => "/Croma/Presentacion/html/incidenciascreadas.php"],
    "ficha"          => ["etiqueta" => "Ficha", "ruta" => "/Croma/Presentacion/html/usuario/ficha.php"],
    "administrador"  => ["etiqueta" => "Administrador", "ruta" => "/Croma/Presentacion/html/admin/administrador.php"],
    "kanban" => ["etiqueta" => "Tablero Kanban", "ruta" => "/Croma/Presentacion/html/tecnico/kanban.php"]
];

$permisos = [
    "admin"       => ["index_admin", "inventario", "salones", "tickets", "incidenciascreadas", "ficha", "administrador", "kanban"],
    "tecnico"     => ["index_tecnico", "inventario", "salones", "tickets", "incidenciascreadas", "kanban"],
    "solicitante" => ["index_user", "tickets", "incidenciascreadas", "ficha"]
];

$acciones = [
    "eliminarTickets"  => ["admin", "tecnico"],
    "asignarPrioridad" => ["tecnico"]
];

$InicioPorRol = [
    "admin"       => "/Croma/Presentacion/html/admin/index_admin.php",
    "tecnico"     => "/Croma/Presentacion/html/tecnico/index_tecnico.php",
    "solicitante" => "/Croma/Presentacion/html/usuario/index_user.php"
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
if (!isset($acciones[$accion])) {
    return false;
}
    return in_array($rol, $acciones[$accion]);

}







?>