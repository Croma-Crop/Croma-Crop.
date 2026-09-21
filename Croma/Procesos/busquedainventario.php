<?php

require_once __DIR__ . "/backend/sanitizar.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombrebusqueda = limpiarTextoCorto($_POST['nombre'] ?? '', 50);

    if ($nombrebusqueda !== '') {

        header(
            "Location: ../Presentacion/html/inventario.php?buscar="
            . urlencode($nombrebusqueda)
        );

        exit;
    }

    header("Location: ../Presentacion/html/inventario.php");
    exit;
}
