<?php

$moduloRequerido = "inventario";
require_once __DIR__ . "/backend/guardia.php";
require_once __DIR__ . "/backend/sanitizar.php";

require_once '../Datos/Clases/ClassInventario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!puedeHacer("darDeBajaEquipos", $_SESSION["rol"])) {
        header('Location: ../Presentacion/html/inventario.php?mensaje=' . urlencode("Solo un administrador puede dar de baja un equipo") . '&tipo=error');
        exit;
    }

    $numero_serie = limpiarSerie($_POST['numero_serie'] ?? '');

    if ($numero_serie === "") {
        header('Location: ../Presentacion/html/inventario.php?mensaje=' . urlencode("Falta el numero de serie del equipo") . '&tipo=error');
        exit;
    }

    $inventario = new Inventario($conexion, $numero_serie, "", "", "", "", NULL, NULL);

    $estadoActual = $inventario->buscarEstado($numero_serie);

    if ($estadoActual === "") {
        header('Location: ../Presentacion/html/inventario.php?mensaje=' . urlencode("El equipo no existe en el inventario") . '&tipo=error');
        exit;
    }

    if ($estadoActual === "de_baja") {
        header('Location: ../Presentacion/html/inventario.php?mensaje=' . urlencode("El equipo ya estaba dado de baja") . '&tipo=error');
        exit;
    }

    $ok = $inventario->darDeBaja($numero_serie);

    if ($ok) {
        header('Location: ../Presentacion/html/inventario.php?mensaje=' . urlencode("Equipo dado de baja correctamente") . '&tipo=exito');
    } else {
        header('Location: ../Presentacion/html/inventario.php?mensaje=' . urlencode("No se pudo dar de baja el equipo") . '&tipo=error');
    }
    exit;
}

?>
