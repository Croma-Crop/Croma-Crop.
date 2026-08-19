<?php
require "../../Datos/Clases/ClassSalones.php";
$tablasalon = Salon::mostrar();
$editando = null;
if (isset($_GET['editar'])) {
    $idmodificado = $_GET['editar'];
    $consulta = new Salon($conexion, "", "", $idmodificado);
    $editando = $consulta->buscarporid($idmodificado);
}



?>
