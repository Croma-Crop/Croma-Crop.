<?php

require_once __DIR__ . '/../Datos/Clases/ClassSolicitudUsuario.php';
require_once __DIR__ . '/../Datos/DataBase/ConexionMYSQL/conexion.php';

$solicitudesPendientes = SolicitudUsuario::mostrarPendientes($conexion);
$solicitudesResueltas = SolicitudUsuario::mostrarResueltas($conexion);
