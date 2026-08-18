<?php
session_start();
require '../../Datos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contraseñaIngresada = $_POST['password'];
    $empleado = null;
    $mensaje = "";

    if (!empty($_POST['pasaporte'])) {
        $documentoIngresado = trim($_POST['pasaporte']);
        $mensaje = "Pasaporte o contraseña incorrectos.";
    } else {
        $documentoIngresado = trim($_POST['cedula'] ?? '');
        $mensaje = "Cédula o contraseña incorrectos.";
    }

    $stmt = mysqli_prepare($conexion,
        "SELECT documento, nombre, apellido, contrasena, rol FROM usuario WHERE documento = ?"
    );
    mysqli_stmt_bind_param($stmt, "s", $documentoIngresado);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $filaUsuario = mysqli_fetch_assoc($resultado);

    if ($filaUsuario && password_verify($contraseñaIngresada, $filaUsuario['contrasena'])) {
        $mapaRoles = [
            'administrador' => 'admin',
            'tecnico'       => 'tecnico',
            'solicitante'   => 'solicitante',
        ];
        $rolCorto = $mapaRoles[$filaUsuario['rol']] ?? null;

        $empleado = [
            "nombre"   => $filaUsuario['nombre'],
            "apellido" => $filaUsuario['apellido'],
            "rol"      => $rolCorto
        ];
    }

    if (!$empleado) {
        $_SESSION["error"] = $mensaje;
        header("Location: ../../Presentacion/index.php");
        exit;
    } else {
        $_SESSION["usuarioActivo"] = [
            "nombre"   => $empleado['nombre'],
            "apellido" => $empleado['apellido'],
            "rol"      => $empleado['rol']
        ];
        $_SESSION["rol"] = $empleado['rol'];

        if ($empleado['rol'] === "admin") {
            header("Location: ../../Presentacion/html/admin/index_admin.php");
            exit;
        } else if ($empleado['rol'] === "tecnico") {
            header("Location: ../../Presentacion/html/tecnico/index_tecnico.php");
            exit;
        } else if ($empleado['rol'] === "solicitante") {
            header("Location: ../../Presentacion/html/usuario/index_user.php");
            exit;
        }
    }
}
?>

