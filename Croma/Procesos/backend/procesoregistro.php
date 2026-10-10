<?php

require_once __DIR__ . "/sanitizar.php";
require_once '../../Datos/Clases/ClassUsuario.php';
require_once '../../Datos/Clases/ClassUsuarioextranjero.php';
require_once '../../Datos/DataBase/ConexionMYSQL/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $documento = limpiarDocumento($_POST['documento'] ?? $_POST['pasaporte'] ?? '');
    $nombre = limpiarTextoCorto($_POST['nombre'] ?? '', 50);
    $apellido = limpiarTextoCorto($_POST['apellido'] ?? '', 50);
    $rolPedido = limpiarOpcion($_POST['rol_pedido'] ?? '', ["solicitante", "tecnico", "administrador"]);
    $contrasenaIngresada = $_POST['contrasena'] ?? '';
    $contrasenaRepetida = $_POST['contrasena_repetida'] ?? '';
    $tipo = limpiarOpcion($_GET['tipo'] ?? '', ["extranjero"]);


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

    if ($mensajeError === "" && strlen($contrasenaIngresada) < 8) {
        $mensajeError = "La contraseña tiene que tener al menos 8 caracteres";
    }

    if ($mensajeError === "" && $contrasenaIngresada !== $contrasenaRepetida) {
        $mensajeError = "Las dos contraseñas no coinciden";
    }

    if ($mensajeError === "" && Usuario::existe($conexion, $documento)) {
        $mensajeError = "Ese documento ya tiene un usuario en el sistema";
    }


    if ($mensajeError !== "") {
        header("Location: ../../Presentacion/html/registro.php?tipo=error&mensaje=" . urlencode($mensajeError));
        exit;
    }

    $contrasena = password_hash($contrasenaIngresada, PASSWORD_DEFAULT);
    if($tipo === "extranjero"){
    $solicitud = new Usuarioextranjero($conexion, $documento, $nombre, $apellido, $contrasena, $rolPedido, "pendiente");
    }else{
    $solicitud = new Usuario(
        $conexion,
        $documento,
        $nombre,
        $apellido,
        $contrasena,
        $rolPedido,
        "pendiente"
    );
    }

    $ok = $solicitud->crearusuario();

    if ($ok) {
        header("Location: ../../Presentacion/html/registro.php?tipo=exito&mensaje=" . urlencode("Solicitud enviada, un administrador la va a revisar"));
    } else {
        header("Location: ../../Presentacion/html/registro.php?tipo=error&mensaje=" . urlencode("No se pudo enviar la solicitud"));
    }
    exit;
}

?>
