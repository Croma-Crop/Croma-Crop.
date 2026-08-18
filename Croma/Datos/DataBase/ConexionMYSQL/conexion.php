<?php

$conexion = mysqli_connect("localhost", "root", "", "srgsi");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}



?>