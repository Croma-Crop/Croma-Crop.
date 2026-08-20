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

        $usuarios = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $usuarios[] = $fila;
        }
        return $usuarios;
    }

    public function guardar(array $datos): array
    {
        $documento  = trim($datos['cedula'] ?? $datos['pasaporte'] ?? '');
        $nombre     = trim($datos['nombre'] ?? '');
        $apellido   = trim($datos['apellido'] ?? '');
        $rol        = trim($datos['rol'] ?? '');
        $contrasena = $datos['contrasena'] ?? '';

        if ($documento === '' || $nombre === '' || $apellido === '' || $rol === '' || $contrasena === '') {
            return ['error' => 'Faltan datos obligatorios'];
        }

        $rolesValidos = ['solicitante', 'tecnico', 'administrador'];
        if (!in_array($rol, $rolesValidos, true)) {
            return ['error' => 'Rol inválido'];
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
            return ['error' => 'Ya existe un usuario con ese documento'];
        }

        return ['error' => 'Error al guardar: ' . mysqli_error($this->conexion)];
    }

    public function eliminar(string $documento): array
    {
        $documento = trim($documento);

        if ($documento === '') {
            return ['error' => 'Documento no especificado'];
        }

        $stmt = mysqli_prepare(
            $this->conexion,
            "DELETE FROM usuario WHERE documento = ?"
        );
        mysqli_stmt_bind_param($stmt, "s", $documento);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) === 0) {
            return ['error' => 'No existe un usuario con ese documento'];
        }

        return ['ok' => true, 'documento' => $documento];
    }

    public static function esAdministrador(): bool
    {
        return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
    }
}