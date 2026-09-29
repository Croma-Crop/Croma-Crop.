<?php

$moduloRequerido = "administrador";
require_once __DIR__ . "/guardia.php";
require_once __DIR__ . "/sanitizar.php";


require "../../Datos/Clases/ClassUsuario.php";
require "../../Datos/Clases/ClassUsuarioextranjero.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = limpiarOpcion($_GET['tipo'] ?? '', ["extranjero"]);
    $documento = limpiarDocumento($_POST['documento'] ?? $_POST['pasaporte'] ?? '');
    $nombre = limpiarTextoCorto($_POST['nombre'] ?? '', 50);
    $apellido = limpiarTextoCorto($_POST['apellido'] ?? '', 50);
    $rol = limpiarOpcion($_POST['rol'] ?? '', ["administrador", "tecnico", "solicitante"]);
    $contrasenaIngresada = $_POST['contrasena'] ?? '';

    if ($tipo === "extranjero") {
    $documento = limpiarTextoCorto($_POST['pasaporte'] ?? '', 20);
    } else {
    $documento = limpiarTextoCorto($_POST['documento'] ?? '', 8);
    }
    $mensajeError = "";


    if ($documento === "") {
        $mensajeError = "Tenes que ingresar la cedula o el pasaporte del empleado";
    }

    if ($mensajeError === "" && $nombre === "") {
        $mensajeError = "Tenes que ingresar el nombre del empleado";
    }

    if ($mensajeError === "" && $apellido === "") {
        $mensajeError = "Tenes que ingresar el apellido del empleado";
    }

    if ($mensajeError === "" && $rol === "") {
        $mensajeError = "Rol invalido";
    }

    if ($mensajeError === "" && $contrasenaIngresada === "") {
        $mensajeError = "Tenes que ingresar una contraseña";
    }

    if ($mensajeError !== "") {
        header("Location: ../../Presentacion/html/admin/administrador.php?tipo=error&mensaje=" . urlencode($mensajeError));
        exit;
    }

    $contrasena = password_hash($contrasenaIngresada, PASSWORD_DEFAULT);

    if ($tipo === "extranjero") {
     $usuario = Usuarioextranjero::crear($conexion, $rol, $documento, $nombre, $apellido, $contrasena);
    } else {
        $usuario = Usuario::crear($conexion, $rol, $documento, $nombre, $apellido, $contrasena);
    }

    $ok = $usuario->crearusuario();

    if ($ok) {
        header("Location: ../../Presentacion/html/admin/administrador.php?tipo=exito&mensaje=" . urlencode("Empleado guardado correctamente"));
        exit;
    } else {
        header("Location: ../../Presentacion/html/admin/administrador.php?tipo=error&mensaje=" . urlencode("No se pudo crear el empleado"));
        exit;
    }
}
?>
