<?php
$moduloRequerido = "kanban";
require_once __DIR__ . "/guardia.php";
require_once "../../Datos/Clases/ClassIncidencia.php";
require_once "../../Datos/Clases/ClassSolicitud.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!puedeHacer("asignarPrioridad", $_SESSION["rol"])) {
        header("Location: ../../Presentacion/html/tecnico/kanban.php?tipo=error&mensaje=" . urlencode("No tenés permiso para modificar tickets"));
        exit;
    }

    $id = $_POST['id'];
    $clase = $_POST['clase'];
    $campo = $_POST['campo'];
    $valor = $_POST['valor'];

    $camposValidos = ['estado', 'prioridad', 'asignado'];

    if (!in_array($campo, $camposValidos)) {
        header("Location: ../../Presentacion/html/tecnico/kanban.php?tipo=error&mensaje=" . urlencode("El campo no es valido"));
        exit;
    }

    if ($campo === 'prioridad' && $clase !== 'Incidencia') {
        header("Location: ../../Presentacion/html/tecnico/kanban.php?tipo=error&mensaje=" . urlencode("Las solicitudes no tienen prioridad"));
        exit;
    }

    if ($campo === 'asignado' && $valor === '') {
        $valor = null;
    }

    $ok = false;

    if ($clase === 'Incidencia') {
        $incidencia = new Incidencia($conexion, $id, "", "", "", "", null, null);

        if ($campo === 'estado') {
            $ok = $incidencia->cambiarEstado($valor);
        } elseif ($campo === 'prioridad') {
            $ok = $incidencia->cambiarPrioridad($valor);
        } elseif ($campo === 'asignado') {
            $ok = $incidencia->asignarTecnico($valor);
        }
    } elseif ($clase === 'Solicitud') {
        $solicitud = new Solicitud($conexion, $id, "", "", null);

        if ($campo === 'estado') {
            $ok = $solicitud->cambiarEstado($valor);
        } elseif ($campo === 'asignado') {
            $ok = $solicitud->asignarTecnico($valor);
        }
    }

    if ($ok) {
        header("Location: ../../Presentacion/html/tecnico/kanban.php?tipo=exito&mensaje=" . urlencode("Ticket actualizado correctamente"));
    } else {
        header("Location: ../../Presentacion/html/tecnico/kanban.php?tipo=error&mensaje=" . urlencode("No se pudo actualizar el ticket"));
    }
    exit;
}
