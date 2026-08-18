<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "conexion.php";

$usuario = [
    ["documento" => "11111111", "tipo_documento" => "cedula", "nombre" => "Admin",   "apellido" => "Prueba", "contrasena" => "fafealmo", "rol" => "administrador"],
    ["documento" => "22222222", "tipo_documento" => "cedula", "nombre" => "Tecnico", "apellido" => "Prueba", "contrasena" => "fafealmo", "rol" => "tecnico"],
    ["documento" => "33333333", "tipo_documento" => "cedula", "nombre" => "Usuario", "apellido" => "Prueba", "contrasena" => "fafealmo", "rol" => "solicitante"],
];

try {
    $stmt = $conexion->prepare(
        "INSERT INTO usuario (documento, tipo_documento, nombre, apellido, contrasena, rol)
         VALUES (?, ?, ?, ?, ?, ?)"
    );

    foreach ($usuario as $u) {
        $hash = password_hash($u["contrasena"], PASSWORD_DEFAULT);
        $stmt->bind_param(
            "ssssss",
            $u["documento"],
            $u["tipo_documento"],
            $u["nombre"],
            $u["apellido"],
            $hash,
            $u["rol"]
        );
        $stmt->execute();
    }

    echo json_encode(["ok" => true, "mensaje" => "Usuarios de prueba cargados"]);
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    echo json_encode(["ok" => false, "mensaje" => "Error al cargar usuarios (¿ya existen?)"]);
}

/* esto te deberia poner los 3 usuarios ya por defecto en la tabla. Por cierto, no intentes insertarlos directamente en el mysql, no sirve */