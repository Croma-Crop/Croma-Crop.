<?php
session_start();
require "../../Datos/Clases/ClassUsuario.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contraseñaIngresada = $_POST['contrasena'];
    $documento = trim($_POST['documento'] ?? '');
    $empleado = null;
    $mensaje = "Documento o contraseña incorrectos.";

    $usuario = new Usuario($conexion, $documento, "", "", "");
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
        }
        exit;
    }
}
?>