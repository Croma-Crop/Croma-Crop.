<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/permisos.php";

$rutaScript = $_SERVER["SCRIPT_NAME"];
$corte = strpos($rutaScript, "/Procesos/");
$baseGuardia = $corte === false ? "" : substr($rutaScript, 0, $corte);

if (!isset($_SESSION["usuarioActivo"])) {
    header("Location: " . $baseGuardia . "/Presentacion/index.php");
    exit;
}

if (isset($moduloRequerido) && !tienePermiso($_SESSION["rol"], $moduloRequerido)) {
    header("Location: " . $baseGuardia . "/Presentacion/index.php");
    exit;
}
