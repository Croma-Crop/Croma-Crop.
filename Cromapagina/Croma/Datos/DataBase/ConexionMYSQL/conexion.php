<?php


$conexion = mysqli_connect("db", "root", "cromaroot2026", "sgrsi");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

?>
