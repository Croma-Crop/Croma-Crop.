<?php
$scriptPath = $_SERVER['SCRIPT_NAME'];
$posicion = strpos($scriptPath, '/Presentacion/');
$BASE_URL = substr($scriptPath, 0, $posicion);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../../Procesos/backend/sesion.php';

?>
<a class="marca" href="<?php echo $InicioPorRol[$rolSesion]; ?>">
    <img src="<?php echo $BASE_URL ?>/Presentacion/img/removebg-preview.png" alt="Logo Croma Corp" id="logo">
    <span class="marca-texto">Croma Corp</span>
</a>

<nav class="nav-principal" aria-label="Navegación principal">
    <ul class="nav-lista">
        <?php echo construirNav($rolSesion, $moduloactual); ?>
    </ul>
</nav>

<div class="dropdown nav-movil">
    <button class="btn-menu" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Abrir menú de navegación">
        <img src="<?php echo $BASE_URL ?>/Presentacion/img/menu.png" alt="" id="burguer">
    </button>
    <ul class="dropdown-menu">
        <?php echo construirMenu($rolSesion); ?>
    </ul>
</div>

<div class="acciones-header">
    <button class="btn-idioma" type="button" id="btn-idioma">EN</button>
    <?php echo construirChip($usuario); ?>
</div>

<script src="<?php echo $BASE_URL ?>/Presentacion/js/idioma.js"></script>
