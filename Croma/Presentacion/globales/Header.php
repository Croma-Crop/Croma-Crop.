<?php
$scriptPath = $_SERVER['SCRIPT_NAME'];
$posicion = strpos($scriptPath, '/Presentacion/');
$BASE_URL = substr($scriptPath, 0, $posicion);
session_start();
    require __DIR__ . '../../../Procesos/backend/sesion.php';

?>
<a href="<?php echo $InicioPorRol[$rolSesion]; ?>">
    <img src=" <?php echo $BASE_URL ?>/Presentacion/img/removebg-preview.png" alt="Logo Croma Corp" id="logo">
</a>

<ul class="dropdown-menu">
    <?php echo construirMenu($rolSesion); ?>
</ul>

<div class="dropdown">
    <img src="<?php echo $BASE_URL ?>/Presentacion/img/menu.png" alt="burguer" id="burguer" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer">
    <ul class="dropdown-menu">
        <?php echo construirMenu($rolSesion); ?>
    </ul>
</div>
<?php echo construirChip($usuario); ?>
