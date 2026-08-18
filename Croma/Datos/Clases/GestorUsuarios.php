<?php

class GestorUsuarios
{
    private mysqli $conexion;

    public function __construct(mysqli $conexion)
    {
        $this->conexion = $conexion;
    }

    public function listar(): array
    {
        $resultado = mysqli_query(
            $this->conexion,
            "SELECT documento, nombre, apellido, rol FROM usuario"
        );

        $empleados = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $empleados[] = $fila;
        }
        return $empleados;
    }

    public function guardar(array $datos): array
    {
        $documento  = trim($datos['cedula'] ?? $datos['pasaporte'] ?? '');
        $nombre     = trim($datos['nombre'] ?? '');
        $apellido   = trim($datos['apellido'] ?? '');
        $rol        = trim($datos['rol'] ?? '');
        $contrasena = $datos['contrasena'] ?? '';

        if ($documento === '' || $nombre === '' || $apellido === '' || $rol === '' || $contrasena === '') {
            return ['error' => 'Faltan datos obligatorios', 'codigo' => 400];
        }

        $rolesValidos = ['solicitante', 'tecnico', 'administrador'];
        if (!in_array($rol, $rolesValidos, true)) {
            return ['error' => 'Rol inválido', 'codigo' => 400];
        }

        $hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare(
            $this->conexion,
            "INSERT INTO usuario (documento, nombre, apellido, contrasena, rol) VALUES (?, ?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, "sssss", $documento, $nombre, $apellido, $hash, $rol);

        if (mysqli_stmt_execute($stmt)) {
            return ['ok' => true, 'documento' => $documento];
        }

        if (mysqli_errno($this->conexion) === 1062) {
            return ['error' => 'Ya existe un empleado con ese documento', 'codigo' => 409];
        }

        return ['error' => 'Error al guardar: ' . mysqli_error($this->conexion), 'codigo' => 500];
    }

    public static function esAdministrador(): bool
    {
        return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
    }
}