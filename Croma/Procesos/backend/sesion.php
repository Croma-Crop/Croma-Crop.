<?php


require_once 'permisos.php';

$scriptPath = $_SERVER['SCRIPT_NAME'];
$posicion = strpos($scriptPath, '/Presentacion/');
$BASE_URL = substr($scriptPath, 0, $posicion);

$moduloactual = basename($_SERVER['SCRIPT_NAME'], ".php");

if(!isset($_SESSION["usuarioActivo"])){
header('Location:' . $BASE_URL. '/Presentacion/index.php');
exit;
} else if (!tienepermiso($_SESSION["rol"], $moduloactual)){
header("Location: " . $InicioPorRol[$_SESSION["rol"]]);
exit;
}else {
    $rolSesion= $_SESSION["rol"];
$usuario = $_SESSION["usuarioActivo"];
}

function construirMenu($rol){
    global $permisos, $modulos, $InicioPorRol;
$html = "<li><a class='dropdown-item' href='" . $InicioPorRol[$rol] . "'>Inicio</a></li>";
$html .= "<li><hr class='dropdown-divider'></li>";



foreach ($permisos[$rol] as $clave){
if(isset($modulos[$clave])){
$modulo = $modulos[$clave];
$html .= "<li><a class='dropdown-item' href='" . $modulo['ruta'] . "'>" . $modulo['etiqueta'] . "</a></li>";
}
}
return $html;
}


function construirChip($usuario){
    $scriptPath = $_SERVER['SCRIPT_NAME'];
$posicion = strpos($scriptPath, '/Presentacion/');
$BASE_URL = substr($scriptPath, 0, $posicion);
$rol = $usuario["rol"];
if ($usuario["rol"] === "administrador"){
$rol = "administrador";


}
if ($usuario["rol"] === "tecnico"){
$rol = "Técnico";

}
if ($usuario["rol"] === "solicitante") {
        $rol = "Solicitante";
    }

    $chip = "
   <div class='dropdown usuario-chip'>
            <button class='btn-usuario' data-bs-toggle='dropdown' aria-expanded='false'>
                " . htmlspecialchars($usuario['nombre'] . " " . $usuario['apellido']) . "
            </button>
            <ul class='dropdown-menu dropdown-menu-end'>
                <li><span class='dropdown-item-text'>" . $rol . "</span></li>
                <li><hr class='dropdown-divider'></li>
                <li><a class='dropdown-item' href='" . $BASE_URL . "/Procesos/backend/logout.php'>Cerrar sesión</a></li>
            </ul>
        </div>
    
        ";
        
        return $chip;

}





?>