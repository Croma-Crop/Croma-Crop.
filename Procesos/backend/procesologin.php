<?php
session_start();
$empleados = [
    ["cedula" => "11111111", "nombre" => "Admin", "apellido" => "Prueba", "rol" => "admin", "contrasena" => "fafealmo"],
    ["cedula" => "22222222", "nombre" => "Tecnico", "apellido" => "Prueba", "rol" => "tecnico", "contrasena" => "fafealmo"],
    ["cedula" => "33333333", "nombre" => "Usuario", "apellido" => "Prueba", "rol" => "solicitante", "contrasena" => "fafealmo"]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contraseñaIngresada = $_POST['password'];
    $empleado = null;
    $mensaje = "";



 if (!empty($_POST['pasaporte'])) {
        $pasaporteIngresado = trim($_POST['pasaporte']);
        foreach ($empleados as $emp) {
            if (($emp['pasaporte'] ?? null) === $pasaporteIngresado && $emp['contrasena'] === $contraseñaIngresada) {
                $empleado = $emp;
                break;
            }
        }
 
        $mensaje = "Pasaporte o contraseña incorrectos.";
    } else {
        $cedulaIngresada = trim($_POST['cedula'] ?? '');
        foreach ($empleados as $emp) {
            if (($emp['cedula'] ?? null) === $cedulaIngresada && $emp['contrasena'] === $contraseñaIngresada) {
                $empleado = $emp;
                break;
            }
        }
        $mensaje = "Cédula o contraseña incorrectos.";
    }

   if (!$empleado) {
    $_SESSION["error"] = $mensaje;
    header("Location: /Croma/Presentacion/index.php");
    exit;
} else {
    $_SESSION["usuarioActivo"] = [
        "nombre" => $empleado['nombre'],
        "apellido" => $empleado['apellido'],
        "rol" => $empleado['rol']
    ];
    $_SESSION["rol"] = $empleado['rol'];

    if ($empleado['rol'] === "admin") {
        header("Location: ../../Presentacion/html/admin/index_admin.php");
    } else {
         if ($empleado['rol'] === "tecnico"){
            header("Location: ../../Presentacion/html/tecnico/index_tecnico.php");
            exit;
         } else{
            if ($empleado['rol'] === "usuario") {
        header("Location: ../../Presentacion/html/usuario/index_user.php");
        exit;
         }
    
    exit;
}
    }
}
    }

?>

