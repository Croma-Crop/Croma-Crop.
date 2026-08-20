<?php

require "../../Datos/Clases/ClassUsuario.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $documento = $_POST['documento'];
    $rol = $_POST['rol'];

    if ($documento !== "") {

        $usuario = new $rol(
            $conexion,
            $documento,
            $nombre,
            $apellido,
            $contrasena
        );
        
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