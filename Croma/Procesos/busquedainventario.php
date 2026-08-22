<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['nombre']) && trim($_POST['nombre']) !== '') {

        $nombrebusqueda = trim($_POST['nombre']);

        header(
            "Location: ../Presentacion/html/inventario.php?buscar="
            . urlencode($nombrebusqueda)
        );

        exit;
    }

    header("Location: ../Presentacion/html/inventario.php");
    exit;
}