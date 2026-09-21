<?php

require_once __DIR__ . "/../DataBase/ErroresBD.php";
require_once __DIR__ . '/../DataBase/ConexionMYSQL/conexion.php';

class Incidencia {
    public mysqli $conexion;
    public ?int $id_incidencia;
    public string $fecha;
    public string $descripcion;
    public string $prioridad;
    public string $turno;
    public ?string $fecha_limite;
    public ?string $tecnico;
    public string $estado;
    public ?string $numero_serie;

    public function __construct(
        mysqli $conexion,
        ?int $id_incidencia,
        string $fecha,
        string $descripcion,
        string $prioridad,
        string $turno,
        ?string $fecha_limite,
        ?string $tecnico,
        string $estado = 'Pendiente',
        ?string $numero_serie = null
    ) {
        $this->conexion = $conexion;
        $this->id_incidencia = $id_incidencia;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->prioridad = $prioridad;
        $this->turno = $turno;
        $this->fecha_limite = $fecha_limite;
        $this->tecnico = $tecnico;
        $this->estado = $estado;
        $this->numero_serie = $numero_serie;
    }

    public static function mostrar($conexion) {
        $sql = "SELECT id_incidencia, fecha, fecha_limite, turno, estado, tipo, descripcion, prioridad, cedula_solicitante, cedula_tecnico, numero_serie
                FROM incidencia
                ORDER BY fecha DESC";
        $resultado = $conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function guardar($tipo, $cedulaSolicitante) {
        try {
            $sql = "INSERT INTO incidencia (fecha, fecha_limite, turno, estado, tipo, descripcion, prioridad, cedula_solicitante, cedula_tecnico, numero_serie)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);

            if (!$stmt) {
                return false;
            }

            $stmt->bind_param("ssssssssss", $this->fecha, $this->fecha_limite, $this->turno, $this->estado, $tipo, $this->descripcion, $this->prioridad, $cedulaSolicitante, $this->tecnico, $this->numero_serie);

            return $stmt->execute();

        } catch (mysqli_sql_exception $e) {
            return registrarErrorBD($e, "Incidencia");
        }
    }
    public function borrar($id_incidencia) {
    $sql = "DELETE FROM incidencia WHERE id_incidencia = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("i", $id_incidencia);
    return $stmt->execute();
}
public function cambiarEstado(string $nuevoEstado): bool {
    try {
        $sql = "UPDATE incidencia SET estado = ? WHERE id_incidencia = ?";
        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $nuevoEstado, $this->id_incidencia);

        return $stmt->execute();

    } catch (mysqli_sql_exception $e) {
        return false;
    }
}

public function cambiarPrioridad(string $nuevaPrioridad): bool {
    try {
        $sql = "UPDATE incidencia SET prioridad = ? WHERE id_incidencia = ?";
        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $nuevaPrioridad, $this->id_incidencia);

        return $stmt->execute();

    } catch (mysqli_sql_exception $e) {
        return false;
    }
}
public static function siguienteGravedad($gravedadActual) {
    if ($gravedadActual === "Sin asignar") {
        return "Baja";
    }
    if ($gravedadActual === "Baja") {
        return "Media";
    }
    if ($gravedadActual === "Media") {
        return "Alta";
    }
    return "Alta";
}

public static function buscarEquivalentes($conexion, $numero_serie, $descripcion) {
    $sql = "SELECT id_incidencia, prioridad
            FROM incidencia
            WHERE numero_serie = ? AND descripcion = ? AND estado <> 'Resuelto'";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        return [];
    }

    $stmt->bind_param("ss", $numero_serie, $descripcion);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

public static function escalarPorRepeticion($conexion, $numero_serie, $descripcion) {

    $equivalentes = Incidencia::buscarEquivalentes($conexion, $numero_serie, $descripcion);
    $repetidas = count($equivalentes);

    if ($repetidas === 0) {
        return ["gravedad" => "Sin asignar", "repetidas" => 0];
    }

    $gravedad = "Sin asignar";

    foreach ($equivalentes as $equivalente) {
        if ($equivalente['prioridad'] === "Alta") {
            $gravedad = "Alta";
        } elseif ($equivalente['prioridad'] === "Media" && $gravedad !== "Alta") {
            $gravedad = "Media";
        } elseif ($equivalente['prioridad'] === "Baja" && $gravedad === "Sin asignar") {
            $gravedad = "Baja";
        }
    }

    $gravedad = Incidencia::siguienteGravedad($gravedad);

    foreach ($equivalentes as $equivalente) {
        $repetida = new Incidencia($conexion, $equivalente['id_incidencia'], "", "", "", "", null, null);
        $repetida->cambiarPrioridad($gravedad);
    }

    return ["gravedad" => $gravedad, "repetidas" => $repetidas];
}

public function buscarTecnicoAsignado($id_incidencia) {
    $sql = "SELECT cedula_tecnico FROM incidencia WHERE id_incidencia = ?";
    $stmt = $this->conexion->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("i", $id_incidencia);
    $stmt->execute();
    $fila = $stmt->get_result()->fetch_assoc();

    if (!$fila) {
        return false;
    }

    return $fila['cedula_tecnico'];
}

public function asignarTecnico(?string $cedulaTecnico): bool {
    try {
        $sql = "UPDATE incidencia SET cedula_tecnico = ? WHERE id_incidencia = ?";
        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $cedulaTecnico, $this->id_incidencia);

        return $stmt->execute();

    } catch (mysqli_sql_exception $e) {
        return false;
    }
}

}