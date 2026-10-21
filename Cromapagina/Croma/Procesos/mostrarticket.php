<?php

require __DIR__ . '/../Datos/Clases/ClassIncidencia.php';
require __DIR__ . '/../Datos/Clases/ClassSolicitud.php';


$incidencias = Incidencia::mostrar($conexion);
$solicitudes = Solicitud::mostrar($conexion);

?>