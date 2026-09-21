<?php

$moduloRequerido = "administrador";
require_once __DIR__ . "/backend/guardia.php";
require_once __DIR__ . "/backend/sanitizar.php";

require_once '../Datos/Clases/ClassSolicitudUsuario.php';
require_once '../Datos/Clases/ClassUsuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!puedeHacer("aprobarUsuarios", $_SESSION["rol"])) {
        header('Location: ../Presentacion/html/admin/index_admin.php?mensaje=' . urlencode("Solo un administrador puede resolver las solicitudes de registro") . '&tipo=error');
        exit;
    }

    $id = limpiarEntero($_POST['id_solicitud_usuario'] ?? '');
    $accion = limpiarOpcion($_POST['accion'] ?? '', ["aprobar", "rechazar"]);
    $motivoRechazo = limpiarTexto($_POST['motivo_rechazo'] ?? '');

    if ($id === "" || $accion === "") {
        header('Location: ../Presentacion/html/admin/index_admin.php?mensaje=' . urlencode("Faltan datos para resolver la solicitud") . '&tipo=error');
        exit;
    }

    $solicitud = new SolicitudUsuario($conexion, $id, "", "", "", "", "solicitante", "");
    $datos = $solicitud->buscarporid($id);

    if (!$datos) {
        header('Location: ../Presentacion/html/admin/index_admin.php?mensaje=' . urlencode("La solicitud de registro no existe") . '&tipo=error');
        exit;
    }

    if ($datos['estado'] !== "Pendiente") {
        header('Location: ../Presentacion/html/admin/index_admin.php?mensaje=' . urlencode("Esa solicitud ya fue resuelta") . '&tipo=error');
        exit;
    }

    $miDocumento = $_SESSION['usuarioActivo']['documento'] ?? '';

    if ($accion === "rechazar") {

        if ($motivoRechazo === "") {
            header('Location: ../Presentacion/html/admin/index_admin.php?mensaje=' . urlencode("Tenes que escribir el motivo del rechazo") . '&tipo=error');
            exit;
        }

        $ok = $solicitud->resolver($id, "Rechazada", $miDocumento, $motivoRechazo);

        if ($ok) {
            header('Location: ../Presentacion/html/admin/index_admin.php?mensaje=' . urlencode("Solicitud rechazada") . '&tipo=exito');
        } else {
            header('Location: ../Presentacion/html/admin/index_admin.php?mensaje=' . urlencode("No se pudo rechazar la solicitud") . '&tipo=error');
        }
        exit;
    }

    if (Usuario::existe($conexion, $datos['documento'])) {
        header('Location: ../Presentacion/html/admin/index_admin.php?mensaje=' . urlencode("Ese documento ya tiene un usuario") . '&tipo=error');
        exit;
    }

    $usuarioNuevo = Usuario::crear($conexion, $datos['rol_pedido'], $datos['documento'], $datos['nombre'], $datos['apellido'], $datos['contrasena']);

    if (!$usuarioNuevo) {
        header('Location: ../Presentacion/html/admin/index_admin.php?mensaje=' . urlencode("El rol de la solicitud no es valido") . '&tipo=error');
        exit;
    }

    if (!$usuarioNuevo->crearusuario()) {
        header('Location: ../Presentacion/html/admin/index_admin.php?mensaje=' . urlencode("No se pudo crear el usuario") . '&tipo=error');
        exit;
    }

    $ok = $solicitud->resolver($id, "Aprobada", $miDocumento, null);

    if ($ok) {
        header('Location: ../Presentacion/html/admin/index_admin.php?mensaje=' . urlencode("Usuario aprobado y creado correctamente") . '&tipo=exito');
    } else {
        header('Location: ../Presentacion/html/admin/index_admin.php?mensaje=' . urlencode("El usuario se creo pero la solicitud no se pudo marcar como aprobada") . '&tipo=error');
    }
    exit;
}

?>
