<?php

$conexion = mysqli_connect("localhost", "root", "", "sgrsi");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}



?>