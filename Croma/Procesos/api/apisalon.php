<?php
header("Content-Type: application/json; charset=utf-8");

require_once '../../Datos/Clases/ClassSalones.php';
$con = $conexion;

function responder($codigo, $status, $mensaje, $data = null) {
    http_response_code($codigo);
    echo json_encode([
        "status"  => $status,
        "message" => $mensaje,
        "data"    => $data
    ]);
    exit;
}

$metodo = $_SERVER["REQUEST_METHOD"];
$id = isset($_GET["id"]) ? (int) $_GET["id"] : null;
$body = json_decode(file_get_contents("php://input"), true) ?? [];

if ($metodo === "POST") {
    $nombre = trim($body["nombre"] ?? "");
    $tipo   = trim($body["tipo"]   ?? "");
    if ($nombre === "" || $tipo === "") {
        responder(400, "error", "Faltan nombre o tipo");
    }
    $salon = new Salon($con, $tipo, $nombre, "");
    if ($salon->guardar() === true) {
        responder(201, "success", "Salón creado", [
            "id_salon" => $con->insert_id,
            "nombre"   => $nombre,
            "tipo"     => $tipo
        ]);
    }
    responder(500, "error", "No se pudo crear el salón");
}

if ($metodo === "PUT" && $id !== null) {
    $nombre = trim($body["nombre"] ?? "");
    $tipo   = trim($body["tipo"]   ?? "");
    if ($nombre === "" || $tipo === "") {
        responder(400, "error", "Faltan nombre o tipo");
    }
    $salon = new Salon($con, $tipo, $nombre, (string) $id);
    if ($salon->modificar($id) === true) {
        responder(200, "success", "Salón modificado", [
            "id_salon" => $id,
            "nombre"   => $nombre,
            "tipo"     => $tipo
        ]);
    }
    responder(500, "error", "No se pudo modificar el salón");
}

if ($metodo === "DELETE" && $id !== null) {
    $salon = new Salon($con, "", "", (string) $id);
    $enUso = $salon->estaEnUso($id);
    if ($enUso !== "") {
        responder(409, "error", "No se puede eliminar: " . $enUso);
    }
    if ($salon->borrar($id) === true) {
        responder(200, "success", "Salón eliminado", ["id_salon" => $id]);
    }
    responder(500, "error", "No se pudo eliminar el salón");
}

responder(405, "error", "Método no soportado o falta id");