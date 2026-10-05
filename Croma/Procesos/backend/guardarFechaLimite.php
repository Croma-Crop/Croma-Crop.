<?php
require_once '../../Datos/Clases/ClassIncidencia.php';
require_once '../../Datos/DataBase/ConexionMYSQL/conexion.php';
if ($_SERVER['REQUEST_METHOD'] === "POST"){
$fecha_limite = $_POST['fecha'];
$id = $_POST['id_incidencia'];
$fechaguardada = new Incidencia($conexion, $id, "", "", "", $fecha_limite, "", "", "");
$ok = $fechaguardada->asignarFechaLimite($fecha_limite);
if($ok) {
    header("Location: ../../Presentacion/html/tecnico/kanban.php?tipo=exito&mensaje=" . urlencode("Fecha actualizada correctamente"));
        exit;
}else{
    header("Location: ../../Presentacion/html/tecnico/kanban.php?tipo=error&mensaje=" . urlencode("Error al guardar la fecha limite"));
        exit;
}



}
















?>