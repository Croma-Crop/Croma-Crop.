<?php
require "../../Datos/Clases/ClassSalones.php";
$nombreingresados = $_POST["nombre"];
$tipoingresados = $_POST["tipo"];
print_r($_POST);
$salones = new Salon($conexion, $tipoingresados, $nombreingresados);
if($salones->guardar()){
    header("Location: ../../Presentacion/html/salones.php?mensaje=Salon ingresado correctamente&tipo=exito");
    
}else{
    header("Location: ../../Presentacion/html/salones.php?mensaje=Salon no fue ingresado correctamente&tipo=error");
   
}
exit;


?>
