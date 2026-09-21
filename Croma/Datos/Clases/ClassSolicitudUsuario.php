<?php

require_once __DIR__ . "/../DataBase/ErroresBD.php";
require_once __DIR__ . '/../DataBase/ConexionMYSQL/conexion.php';

class SolicitudUsuario {
    public mysqli $conexion;
    public ?int $id_solicitud_usuario;
    public string $documento;
    public string $nombre;
    public string $apellido;
    public string $contrasena;
    public string $rol_pedido;
    public string $motivo;
    public string $estado;

    public function __construct(
        mysqli $conexion,
        ?int $id_solicitud_usuario,
        string $documento,
        string $nombre,
        string $apellido,
        string $contrasena,
        string $rol_pedido,
        string $motivo,
        string $estado = 'Pendiente'
    ) {
        $this->conexion = $conexion;
        $this->id_solicitud_usuario = $id_solicitud_usuario;
        $this->documento = $documento;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->contrasena = $contrasena;
        $this->rol_pedido = $rol_pedido;
        $this->motivo = $motivo;
        $this->estado = $estado;
    }

    public function guardar(): bool {
        try {
            $sql = "INSERT INTO solicitud_usuario (documento, nombre, apellido, contrasena, rol_pedido, motivo, estado, fecha)
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $this->conexion->prepare($sql);

            if (!$stmt) {
                return false;
            }

            $stmt->bind_param("sssssss", $this->documento, $this->nombre, $this->apellido, $this->contrasena, $this->rol_pedido, $this->motivo, $this->estado);

            return $stmt->execute();

        } catch (mysqli_sql_exception $e) {
            return registrarErrorBD($e, "SolicitudUsuario");
        }
    }

    public static function mostrarPendientes($conexion) {
        $estadoPendiente = "Pendiente";
        $sql = "SELECT id_solicitud_usuario, documento, nombre, apellido, rol_pedido, motivo, estado, fecha
                FROM solicitud_usuario
                WHERE estado = ?
                ORDER BY fecha ASC";
        $stmt = $conexion->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $stmt->bind_param("s", $estadoPendiente);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function mostrarResueltas($conexion) {
        $sql = "SELECT solicitud_usuario.id_solicitud_usuario, solicitud_usuario.documento, solicitud_usuario.nombre,
                       solicitud_usuario.apellido, solicitud_usuario.rol_pedido, solicitud_usuario.estado,
                       solicitud_usuario.fecha, solicitud_usuario.motivo_rechazo,
                       usuario.nombre AS nombre_administrador, usuario.apellido AS apellido_administrador
                FROM solicitud_usuario
                LEFT JOIN usuario ON solicitud_usuario.cedula_administrador = usuario.documento
                WHERE solicitud_usuario.estado <> 'Pendiente'
                ORDER BY solicitud_usuario.fecha DESC";
        $resultado = $conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public static function existePendiente($conexion, $documento) {
        $estadoPendiente = "Pendiente";
        $sql = "SELECT id_solicitud_usuario FROM solicitud_usuario WHERE documento = ? AND estado = ?";
        $stmt = $conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ss", $documento, $estadoPendiente);
        $stmt->execute();

        if (!$stmt->get_result()->fetch_assoc()) {
            return false;
        }

        return true;
    }

    public function buscarporid($id_solicitud_usuario) {
        $sql = "SELECT id_solicitud_usuario, documento, nombre, apellido, contrasena, rol_pedido, motivo, estado
                FROM solicitud_usuario
                WHERE id_solicitud_usuario = ?";
        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id_solicitud_usuario);
        $stmt->execute();
        $fila = $stmt->get_result()->fetch_assoc();

        if (!$fila) {
            return false;
        }

        return $fila;
    }

    public function resolver($id_solicitud_usuario, $nuevoEstado, $cedulaAdministrador, $motivoRechazo): bool {
        try {
            $sql = "UPDATE solicitud_usuario
                    SET estado = ?, cedula_administrador = ?, motivo_rechazo = ?
                    WHERE id_solicitud_usuario = ? AND estado = 'Pendiente'";
            $stmt = $this->conexion->prepare($sql);

            if (!$stmt) {
                return false;
            }

            $stmt->bind_param("sssi", $nuevoEstado, $cedulaAdministrador, $motivoRechazo, $id_solicitud_usuario);

            if (!$stmt->execute()) {
                return false;
            }

            return $stmt->affected_rows > 0;

        } catch (mysqli_sql_exception $e) {
            return registrarErrorBD($e, "SolicitudUsuario");
        }
    }
}
