<?php

require_once __DIR__ . "/sanitizar.php";
require_once '../../Datos/Clases/ClassSolicitudUsuario.php';
require_once '../../Datos/Clases/ClassUsuario.php';
require_once '../../Datos/DataBase/ConexionMYSQL/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $documento = limpiarDocumento($_POST['documento'] ?? $_POST['pasaporte'] ?? '');
    $nombre = limpiarTextoCorto($_POST['nombre'] ?? '', 50);
    $apellido = limpiarTextoCorto($_POST['apellido'] ?? '', 50);
    $rolPedido = limpiarOpcion($_POST['rol_pedido'] ?? '', ["solicitante", "tecnico", "administrador"]);
    $motivo = limpiarTexto($_POST['motivo'] ?? '');
    $contrasenaIngresada = $_POST['contrasena'] ?? '';
    $contrasenaRepetida = $_POST['contrasena_repetida'] ?? '';

    $mensajeError = "";

    if ($documento === "") {
        $mensajeError = "Tenes que ingresar tu cedula o tu pasaporte";
    }

    if ($mensajeError === "" && $nombre === "") {
        $mensajeError = "Tenes que ingresar tu nombre";
    }

    if ($mensajeError === "" && $apellido === "") {
        $mensajeError = "Tenes que ingresar tu apellido";
    }

    if ($mensajeError === "" && $rolPedido === "") {
        $mensajeError = "Tenes que elegir el rol que te corresponde";
    }

    if ($mensajeError === "" && $motivo === "") {
        $mensajeError = "Tenes que escribir el motivo de la solicitud";
    }

    if ($mensajeError === "" && strlen($contrasenaIngresada) < 8) {
        $mensajeError = "La contraseña tiene que tener al menos 8 caracteres";
    }

    if ($mensajeError === "" && $contrasenaIngresada !== $contrasenaRepetida) {
        $mensajeError = "Las dos contraseñas no coinciden";
    }

    if ($mensajeError === "" && Usuario::existe($conexion, $documento)) {
        $mensajeError = "Ese documento ya tiene un usuario en el sistema";
    }

    if ($mensajeError === "" && SolicitudUsuario::existePendiente($conexion, $documento)) {
        $mensajeError = "Ya hay una solicitud pendiente con ese documento";
    }

    if ($mensajeError !== "") {
        header("Location: ../../Presentacion/html/registro.php?tipo=error&mensaje=" . urlencode($mensajeError));
        exit;
    }

    $contrasena = password_hash($contrasenaIngresada, PASSWORD_DEFAULT);

    $solicitud = new SolicitudUsuario(
        $conexion,
        null,
        $documento,
        $nombre,
        $apellido,
        $contrasena,
        $rolPedido,
        $motivo,
        "Pendiente"
    );

    $ok = $solicitud->guardar();

    if ($ok) {
        header("Location: ../../Presentacion/html/registro.php?tipo=exito&mensaje=" . urlencode("Solicitud enviada, un administrador la va a revisar"));
    } else {
        header("Location: ../../Presentacion/html/registro.php?tipo=error&mensaje=" . urlencode("No se pudo enviar la solicitud"));
    }
    exit;
}

?>
