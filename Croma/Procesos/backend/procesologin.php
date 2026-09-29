<?php
session_start();
require_once __DIR__ . "/sanitizar.php";
require "../../Datos/Clases/ClassUsuario.php";
require "../../Datos/Clases/ClassUsuarioextranjero.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = limpiarOpcion($_GET['tipo'] ?? '', ["extranjero"]);
    $contraseñaIngresada = $_POST['contrasena'] ?? '';
    $empleado = null;
    $mensaje = "Documento o contraseña incorrectos.";

    if ($tipo === "extranjero") {
        $documento = limpiarTextoCorto($_POST['pasaporte'] ?? '', 20);
    } else {
        $documento = limpiarTextoCorto($_POST['documento'] ?? '', 8);
    }

    if ($documento === '' || $contraseñaIngresada === '') {
        $_SESSION["error"] = $mensaje;
        header("Location: ../../Presentacion/index.php");
        exit;
    }

    if ($tipo === "extranjero") {
        $usuario = new usuarioextranjero($conexion, $documento, "", "", "");
    } else {
        $usuario = new Usuario($conexion, $documento, "", "", "");
    }

    $filaUsuario = $usuario->iniciarsesion($documento);

    if ($filaUsuario && password_verify($contraseñaIngresada, $filaUsuario['contrasena'])) {
        $empleado = [
            "documento" => $filaUsuario['documento'],
            "nombre"   => $filaUsuario['nombre'],
            "apellido" => $filaUsuario['apellido'],
            "rol"      => $filaUsuario['rol']
        ];
    }

    if (!$empleado) {
        $_SESSION["error"] = $mensaje;
        header("Location: ../../Presentacion/index.php");
        exit;
    } else {
        $_SESSION["usuarioActivo"] = $empleado;
        $_SESSION["rol"] = $empleado['rol'];

        if ($empleado['rol'] === "administrador") {
            header("Location: ../../Presentacion/html/admin/index_admin.php");
        } elseif ($empleado['rol'] === "tecnico") {
            header("Location: ../../Presentacion/html/tecnico/index_tecnico.php");
        } elseif ($empleado['rol'] === "solicitante") {
            header("Location: ../../Presentacion/html/usuario/index_user.php");
        } else {
            $_SESSION["error"] = $mensaje;
            header("Location: ../../Presentacion/index.php");
        }
        exit;
    }
}
?>