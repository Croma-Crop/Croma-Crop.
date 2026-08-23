<?php

$db_host = "localhost";
$db_usuario = "root";
$db_clave = "";
$db_nombre = "srgsi";

$archivo_local = __DIR__ . "/conexion.local.php";

if (file_exists($archivo_local)) {
    require $archivo_local;
}

$conexion = mysqli_connect($db_host, $db_usuario, $db_clave, $db_nombre);

if (!$conexion) {
    error_log("Error de conexion a la base: " . mysqli_connect_error());
    die("No se pudo conectar con la base de datos.");
}

?>
