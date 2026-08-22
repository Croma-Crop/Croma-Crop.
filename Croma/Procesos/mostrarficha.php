<?php


require_once __DIR__ . '/../Datos/Clases/ClassSalones.php';
require_once __DIR__ . '/../Datos/Clases/ClassInventario.php';
require_once __DIR__ . '/../Datos/DataBase/ConexionMYSQL/conexion.php';

$salones = Salon::mostrar($conexion);

$datosInventario = Inventario::mostrar();
$equipos = $datosInventario['equipos'];

$rolProfesor = "solicitante";
$stmtProfesores = $conexion->prepare("SELECT documento, nombre, apellido FROM usuario WHERE rol = ?");
$stmtProfesores->bind_param("s", $rolProfesor);
$stmtProfesores->execute();
$profesores = $stmtProfesores->get_result()->fetch_all(MYSQLI_ASSOC);


?>