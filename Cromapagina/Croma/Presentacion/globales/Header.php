<?php
$scriptPath = $_SERVER['SCRIPT_NAME'];
$posicion = strpos($scriptPath, '/Presentacion/');
$BASE_URL = substr($scriptPath, 0, $posicion);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../../Procesos/backend/sesion.php';

$grupos = [
    "Soporte técnico" => ["tickets", "incidenciascreadas", "kanban", "metricas"],
    "Registro diario" => ["ficha", "historial"],
    "Equipamiento" => ["inventario", "salones"],
    "Administración" => ["administrador"]
];

$esInicio = false;
if ($moduloactual === "index_admin" || $moduloactual === "index_tecnico" || $moduloactual === "index_user") {
    $esInicio = true;
}
?>
<a class="marca" href="<?php echo $InicioPorRol[$rolSesion]; ?>">
    <img src="<?php echo $BASE_URL ?>/Presentacion/img/removebg-preview.png" alt="Logo Croma Corp" id="logo">
    <span class="marca-texto">Croma Corp</span>
</a>

<nav class="nav-principal" aria-label="Navegación principal">
    <a class="nav-enlace nav-inicio<?php if ($esInicio) { echo ' nav-activo'; } ?>" href="<?php echo $InicioPorRol[$rolSesion]; ?>">Inicio</a>
    <button class="nav-enlace btn-modulos<?php if (!$esInicio) { echo ' nav-activo'; } ?>" type="button" id="btn-modulos">Módulos</button>

    <div class="menu-modulos" id="menu-modulos">
        <?php foreach ($grupos as $titulo => $claves): ?>
            <?php
            $tieneModulos = false;
            foreach ($claves as $clave) {
                if (tienePermiso($rolSesion, $clave)) {
                    $tieneModulos = true;
                }
            }
            ?>
            <?php if ($tieneModulos): ?>
                <section class="menu-grupo">
                    <h2 class="menu-titulo"><?php echo $titulo; ?></h2>
                    <ul class="menu-lista">
                        <?php foreach ($claves as $clave): ?>
                            <?php if (tienePermiso($rolSesion, $clave)): ?>
                                <li>
                                    <a class="menu-enlace<?php if ($moduloactual === $clave) { echo ' menu-activo'; } ?>" href="<?php echo $modulos[$clave]['ruta']; ?>"><?php echo $modulos[$clave]['etiqueta']; ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</nav>

<div class="acciones-header">
    <button class="btn-idioma" type="button" id="btn-idioma">EN</button>
    <?php echo construirChip($usuario); ?>
</div>

<script src="<?php echo $BASE_URL ?>/Presentacion/js/idioma.js"></script>
<script src="<?php echo $BASE_URL ?>/Presentacion/js/menu.js"></script>
