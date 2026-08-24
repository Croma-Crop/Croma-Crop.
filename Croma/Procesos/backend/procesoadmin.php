<?php

$moduloRequerido = "administrador";
require_once __DIR__ . "/guardia.php";


require "../../Datos/Clases/ClassUsuario.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $documento = $_POST['documento'];
    $rol = $_POST['rol'];

    $rolesValidos = ["administrador", "tecnico", "solicitante"];

    if (!in_array($rol, $rolesValidos)) {
        header("Location: ../../Presentacion/html/admin/administrador.php?mensaje=" . urlencode("Rol invalido"));
        exit;
    }

    if ($documento !== "") {

        $usuario = Usuario::crear($conexion, $rol, $documento, $nombre, $apellido, $contrasena);
        
        $ok = $usuario->crearusuario();

        if ($ok) {
            header("Location: ../../Presentacion/html/admin/administrador.php");
            exit;
        }  else {
            echo "No se pudo crear el usuario";
    }
}
}
?>