<?php
require_once __DIR__ . '/../Datos/Clases/ClassFicha.php';
require_once __DIR__ . '/../Datos/Clases/ClassUsuario.php';
require_once __DIR__ . '/../Datos/Clases/ClassSalones.php';
require_once __DIR__ . '/../Datos/Clases/ClassUsuarioextranjero.php';
require_once __DIR__ . '/../Datos/DataBase/ConexionMYSQL/conexion.php';


$fichas = Ficha::mostrar($conexion);
$usuario = Usuario::mostrarsolicitantes($conexion);
$usuarioextranjero = Usuarioextranjero::mostrarsolicitantes($conexion);
$usuarios = array_merge($usuario, $usuarioextranjero);
$salonficha = new Salon($conexion, "", "", "");
$usuariodoc = new Usuario($conexion, "", "", "", "", "");
$usuarioextranjerodoc = new Usuarioextranjero($conexion, "", "", "", "", "");
$rolSesion = $_SESSION['rol'];
$usuarioSesion = $_SESSION['usuarioActivo']["documento"];   

foreach ($fichas as $i => $ficha) {
    $salon = $salonficha->buscaridficha($ficha['id_salon']);
    $fichas[$i]['salon'] = $salon['nombre'];

    $documento = $ficha['cedula_solicitante'];
    $persona = $usuariodoc->buscarpordocumento($documento);

    if (empty($persona)) {
        $persona = $usuarioextranjerodoc->buscarpordocumento($documento);
    }

    $fichas[$i]['solicitante'] = $persona['nombre'] ?? 'No encontrado';
}
if ($rolSesion == 'administrador') {
    $documentoactivo = $_GET['documento'] ?? null;
} else {
    $documentoactivo = $usuarioSesion; 
}

$usuariobuscado = new Ficha($conexion, null, "", "", "", "", "");
$resultado = $usuariobuscado->mostrarporusuario($documentoactivo);

$salonficha = new Salon($conexion, "", "", "");
foreach ($resultado as $i => $ficha) {
    $salon = $salonficha->buscaridficha($ficha['id_salon']);
    $resultado[$i]['salon'] = $salon['nombre'];
}

$tienefichas = !empty($resultado);
