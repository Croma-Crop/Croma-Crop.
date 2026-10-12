<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets creados</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/incidencias.css">
    <script src="../js/incidencias.js" defer></script>
   
</head>
<body data-modulo="incidencias">
    <header>
       <h1 id="titulo">Tickets creados</h1>
        <?php require_once '../globales/Header.php'?>

       

    </header>
    <?php require_once __DIR__ . '/../../Procesos/backend/cargarincidenciascreadas.php'; ?>
    <main>
        <section id="seccion-listado">
            <h3 class="titulo-seccion">Incidencias registradas</h3>
            <div id="controles">
                <input id="inptbusqueda" name="inptbusqueda" placeholder="Buscar por profesor, tipo, salón, serie...">
                <div id="filtros">
                    <button type="button" class="filtro-clase activo" data-clase="Todos">Todos</button>
                    <button type="button" class="filtro-clase" data-clase="Incidencia">Incidencias</button>
                    <button type="button" class="filtro-clase" data-clase="Solicitud">Solicitudes</button>
                </div>
            </div>
            <ul id="listado-tickets">
        <?php if (empty($tickets)): ?>
            <li class="sin-resultados">No hay tickets registrados.</li>
        <?php else: ?>
            <?php foreach ($tickets as $ticket): ?>
        <li class="tarjeta-ticket" data-clase="<?= htmlspecialchars($ticket['clase']) ?>">
            <p class="tarjeta-clase tarjeta-<?= strtolower($ticket['clase']) ?>"><?= htmlspecialchars($ticket['clase']) ?></p>
            <p class="tarjeta-tipo"><span>Tipo:</span> <?= htmlspecialchars($ticket['tipo']) ?></p>
            <p class="tarjeta-nombre"><span>Registrado por:</span> <?= htmlspecialchars($ticket['nombreProf']) ?></p>
            <p class="tarjeta-asignado"><span>Técnico:</span> <?= htmlspecialchars($ticket['nombreTecnico']) ?></p>

            <?php if ($ticket['clase'] === 'Incidencia'): ?>
                <p><span>Fecha:</span> <?= htmlspecialchars($ticket['fecha']) ?></p>
                <?php if($ticket['fecha_limite'] !== null):  ?>
                <p><span>Fecha de finalización:</span> <?= htmlspecialchars($ticket['fecha_limite']) ?></p>
                <?php endif;?>
                <p><span>Turno:</span> <?= htmlspecialchars($ticket['turno']) ?></p>
                <p><span>Equipo:</span> <?= htmlspecialchars($ticket['equipoNombre']) ?></p>
                <p><span>Marca:</span> <?= htmlspecialchars($ticket['equipoMarca']) ?></p>
                <p><span>Modelo:</span> <?= htmlspecialchars($ticket['equipoModelo']) ?></p>
                <p><span>Serie:</span> <?= htmlspecialchars($ticket['numero_serie'] ?? '-') ?></p>
                <p class="tarjeta-prioridad"><span>Gravedad:</span> <span class="gravedad-chip" data-gravedad="<?= htmlspecialchars($ticket['prioridad']) ?>"><?= htmlspecialchars($ticket['prioridad']) ?></span></p>
            <?php endif; ?>

            <?php if ($ticket['clase'] === 'Solicitud'): ?>
                <?php if ($ticket['nombre_software'] !== null && $ticket['nombre_software'] !== ''): ?>
                    <p><span>Software pedido:</span> <?= htmlspecialchars($ticket['nombre_software']) ?></p>
                <?php endif; ?>
                <?php if ($ticket['fecha'] !== null && $ticket['fecha'] !== ''): ?>
                    <p><span>Fecha de uso:</span> <?= htmlspecialchars($ticket['fecha']) ?></p>
                <?php endif; ?>
                <?php if ($ticket['hora_inicio'] !== null && $ticket['hora_inicio'] !== ''): ?>
                    <p><span>Horario:</span> <?= htmlspecialchars($ticket['hora_inicio']) ?> - <?= htmlspecialchars($ticket['hora_fin']) ?></p>
                <?php endif; ?>
            <?php endif; ?>

            <p class="tarjeta-descripcion"><?= htmlspecialchars($ticket['descripcion']) ?></p>
            <p class="linea-estado"><span>Estado:</span> <span class="estado-chip" data-estado="<?= htmlspecialchars($ticket['estado']) ?>"><?= htmlspecialchars($ticket['estado']) ?></span></p>

            <?php if (puedeHacer("eliminarTickets", $_SESSION["rol"])): ?>
                <form method="post" action="../../Procesos/eliminarticket.php" style="display:inline">
                    <input type="hidden" name="clase" value="<?= htmlspecialchars($ticket['clase']) ?>">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($ticket['id']) ?>">
                    <button type="submit" onclick="return confirm(traducir('¿Seguro que quiere eliminar este ticket?'))">Eliminar</button>
                </form>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
<?php endif; ?>




            </ul>
            <?php if (isset($_GET["mensaje"])): ?>
                <div class="mensaje mensaje-<?= ($_GET["tipo"] ?? "") === "exito" ? "exito" : "error" ?>">
                    <?= htmlspecialchars($_GET["mensaje"]) ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
    <?php include '../globales/Footer.html' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>