<?php
session_start();
    require $_SERVER['DOCUMENT_ROOT'] . '/Croma/Procesos/backend/sesion.php';
?>
<a href="<?php echo $InicioPorRol[$rolSesion]; ?>">
    <img src="/Croma/Presentacion/img/removebg-preview.png" alt="Logo Croma Corp" id="logo">
</a>

<ul class="dropdown-menu">
    <?php echo construirMenu($rolSesion); ?>
</ul>

<div class="dropdown">
    <img src="/Croma/Presentacion/img/menu.png" alt="burguer" id="burguer" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer">
    <ul class="dropdown-menu">
        <?php echo construirMenu($rolSesion); ?>
    </ul>
</div>
<?php echo construirChip($usuario); ?>
