<?php

require_once __DIR__ .'../../Datos/Clases/ClassIncidencia';
require_once '../../Datos/Clases/ClassSolicitud';
require_once '../../Datos/DataBase/ConexionMYSQL/conexion.php';

$incidencias = Incidencia::mostrar($conexion);
$solicitudes = Solicitud::mostrar($conexion);

?>