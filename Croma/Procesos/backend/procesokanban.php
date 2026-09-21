<?php
$moduloRequerido = "kanban";
require_once __DIR__ . "/guardia.php";
require_once __DIR__ . "/sanitizar.php";
require_once "../../Datos/Clases/ClassIncidencia.php";
require_once "../../Datos/Clases/ClassSolicitud.php";
require_once "../../Datos/Clases/ClassUsuario.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = limpiarEntero($_POST['id'] ?? '');
    $clase = limpiarOpcion($_POST['clase'] ?? '', ["Incidencia", "Solicitud"]);
    $campo = limpiarOpcion($_POST['campo'] ?? '', ["estado", "prioridad", "asignado"]);
    $valor = limpiarTexto($_POST['valor'] ?? '');

    $miDocumento = $_SESSION['usuarioActivo']['documento'] ?? '';

    $mensajeError = "";

    if (!puedeHacer("asignarPrioridad", $_SESSION["rol"])) {
        $mensajeError = "No tenés permiso para modificar tickets";
    }

    if ($mensajeError === "" && ($id === "" || $clase === "" || $campo === "")) {
        $mensajeError = "Faltan datos para actualizar el ticket";
    }

    if ($mensajeError === "" && $campo === 'prioridad' && $clase !== 'Incidencia') {
        $mensajeError = "Las solicitudes no tienen gravedad";
    }

    if ($mensajeError === "" && $campo === 'estado') {
        $valor = limpiarOpcion($valor, ["Pendiente", "En proceso", "Resuelto"]);
        if ($valor === "") {
            $mensajeError = "El estado no es valido";
        }
    }

    if ($mensajeError === "" && $campo === 'prioridad') {
        $valor = limpiarOpcion($valor, ["Sin asignar", "Baja", "Media", "Alta"]);
        if ($valor === "") {
            $mensajeError = "La gravedad no es valida";
        }
    }

    if ($mensajeError === "") {
        if ($clase === 'Incidencia') {
            $ticket = new Incidencia($conexion, $id, "", "", "", "", null, null);
        } else {
            $ticket = new Solicitud($conexion, $id, "", "", null);
        }
    }

    if ($mensajeError === "" && $campo === 'asignado') {

        $valor = limpiarDocumento($valor);
        $tecnicoActual = $ticket->buscarTecnicoAsignado($id);

        if ($tecnicoActual === false) {
            $mensajeError = "El ticket no existe";
        } elseif ($valor !== "" && !Usuario::esTecnico($conexion, $valor)) {
            $mensajeError = "Solo se puede asignar el ticket a un usuario tecnico";
        } elseif (!puedeHacer("asignarTecnico", $_SESSION["rol"])) {

            if ($valor !== $miDocumento) {
                $mensajeError = "Solo un administrador puede asignarle el ticket a otro tecnico";
            } elseif ($tecnicoActual !== null && $tecnicoActual !== $miDocumento) {
                $mensajeError = "El ticket ya lo tiene otro tecnico";
            }
        }

        if ($valor === "") {
            $valor = null;
        }
    }

    if ($mensajeError !== "") {
        header("Location: ../../Presentacion/html/tecnico/kanban.php?tipo=error&mensaje=" . urlencode($mensajeError));
        exit;
    }

    if ($campo === 'estado') {
        $ok = $ticket->cambiarEstado($valor);
    } elseif ($campo === 'prioridad') {
        $ok = $ticket->cambiarPrioridad($valor);
    } else {
        $ok = $ticket->asignarTecnico($valor);
    }

    if ($ok) {
        header("Location: ../../Presentacion/html/tecnico/kanban.php?tipo=exito&mensaje=" . urlencode("Ticket actualizado correctamente"));
    } else {
        header("Location: ../../Presentacion/html/tecnico/kanban.php?tipo=error&mensaje=" . urlencode("No se pudo actualizar el ticket"));
    }
    exit;
}
