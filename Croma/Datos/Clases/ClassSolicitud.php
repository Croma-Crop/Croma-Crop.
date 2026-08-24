<?php

require_once __DIR__ . "/../DataBase/ErroresBD.php";
require_once __DIR__ . '/../DataBase/ConexionMYSQL/conexion.php';

class Solicitud {
    public mysqli $conexion;
    public ?int $id_solicitud;
    public string $tipo;
    public string $descripcion;
    public string $estado;
    public ?int $id_salon;
    public ?string $tecnico;

    public function __construct(
        mysqli $conexion,
        ?int $id_solicitud,
        string $tipo,
        string $descripcion,
        ?int $id_salon,
        ?string $tecnico = null,
        string $estado = 'Pendiente'
    ) {
        $this->conexion = $conexion;
        $this->id_solicitud = $id_solicitud;
        $this->tipo = $tipo;
        $this->descripcion = $descripcion;
        $this->id_salon = $id_salon;
        $this->tecnico = $tecnico;
        $this->estado = $estado;
    }
        public function borrar($id_solicitud) {
    $sql = "DELETE FROM solicitud WHERE id_solicitud = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("i", $id_solicitud);
    return $stmt->execute();
}

    public static function mostrar($conexion) {
        $sql = "SELECT id_solicitud, tipo, descripcion, estado, cedula_solicitante, cedula_tecnico, id_salon
                FROM solicitud";
        $resultado = $conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function guardar($cedulaSolicitante) {
        try {
            $sql = "INSERT INTO solicitud (tipo, descripcion, estado, cedula_solicitante, cedula_tecnico, id_salon)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);

            if (!$stmt) {
                return false;
            }

            $stmt->bind_param("sssssi", $this->tipo, $this->descripcion, $this->estado, $cedulaSolicitante, $this->tecnico, $this->id_salon);

            return $stmt->execute();

        } catch (mysqli_sql_exception $e) {
            return registrarErrorBD($e, "Solicitud");
        }
    }
    public function cambiarEstado(string $nuevoEstado): bool {
    try {
        $sql = "UPDATE solicitud SET estado = ? WHERE id_solicitud = ?";
        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $nuevoEstado, $this->id_solicitud);

        return $stmt->execute();

    } catch (mysqli_sql_exception $e) {
        return false;
    }
}
public function asignarTecnico(?string $cedulaTecnico): bool {
    try {
        $sql = "UPDATE solicitud SET cedula_tecnico = ? WHERE id_solicitud = ?";
        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $cedulaTecnico, $this->id_solicitud);

        return $stmt->execute();

    } catch (mysqli_sql_exception $e) {
        return false;
    }
}
}