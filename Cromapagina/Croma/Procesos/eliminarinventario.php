<?php

$moduloRequerido = "inventario";
require_once __DIR__ . "/backend/guardia.php";
require_once __DIR__ . "/backend/sanitizar.php";

require_once '../Datos/Clases/ClassInventario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!puedeHacer("eliminarEquipos", $_SESSION["rol"])) {
        header('Location: ../Presentacion/html/inventario.php?mensaje=' . urlencode("Solo un administrador puede eliminar un equipo") . '&tipo=error');
        exit;
    }

    $numero_serie = limpiarSerie($_POST['numero_serie'] ?? '');

    if ($numero_serie === "") {
        header('Location: ../Presentacion/html/inventario.php?mensaje=' . urlencode("Falta el numero de serie del equipo") . '&tipo=error');
        exit;
    }

    $inventario = new Inventario($conexion, $numero_serie, "", "", "", "", NULL, NULL);

    if ($inventario->buscarEstado($numero_serie) === "") {
        header('Location: ../Presentacion/html/inventario.php?mensaje=' . urlencode("El equipo no existe en el inventario") . '&tipo=error');
        exit;
    }

    $enUso = $inventario->estaEnUso($numero_serie);

    if ($enUso !== "") {
        $mensaje = "No se puede eliminar el equipo porque tiene " . $enUso . ". Dalo de baja para conservar su historial.";
        header('Location: ../Presentacion/html/inventario.php?mensaje=' . urlencode($mensaje) . '&tipo=error');
        exit;
    }

    $ok = $inventario->borrar($numero_serie);

    if ($ok) {
        header('Location: ../Presentacion/html/inventario.php?mensaje=' . urlencode("Equipo eliminado correctamente") . '&tipo=exito');
    } else {
        header('Location: ../Presentacion/html/inventario.php?mensaje=' . urlencode("No se pudo eliminar el equipo") . '&tipo=error');
    }
    exit;
}

?>
