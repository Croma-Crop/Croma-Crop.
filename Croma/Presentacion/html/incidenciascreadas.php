<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets Creados</title>
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
            <h3 class="titulo-seccion">Incidencias Registradas</h3>
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
            <p class="tarjeta-tipo">Tipo: <?= htmlspecialchars($ticket['tipo']) ?></p>
            <p class="tarjeta-nombre">Registrado por: <?= htmlspecialchars($ticket['nombreProf']) ?></p>
            <p class="tarjeta-asignado">Técnico: <?= htmlspecialchars($ticket['nombreTecnico']) ?></p>

            <?php if ($ticket['clase'] === 'Incidencia'): ?>
                <p>Fecha: <?= htmlspecialchars($ticket['fecha']) ?></p>
                <p>Turno: <?= htmlspecialchars($ticket['turno']) ?></p>
                <p>Equipo: <?= htmlspecialchars($ticket['equipoNombre']) ?></p>
                <p>Marca: <?= htmlspecialchars($ticket['equipoMarca']) ?></p>
                <p>Modelo: <?= htmlspecialchars($ticket['equipoModelo']) ?></p>
                <p>Serie: <?= htmlspecialchars($ticket['numero_serie'] ?? '-') ?></p>
                <p class="tarjeta-prioridad">Gravedad: <span class="gravedad-chip" data-gravedad="<?= htmlspecialchars($ticket['prioridad']) ?>"><?= htmlspecialchars($ticket['prioridad']) ?></span></p>
            <?php endif; ?>

            <?php if ($ticket['clase'] === 'Solicitud'): ?>
                <?php if ($ticket['nombre_software'] !== null && $ticket['nombre_software'] !== ''): ?>
                    <p>Software pedido: <?= htmlspecialchars($ticket['nombre_software']) ?></p>
                <?php endif; ?>
                <?php if ($ticket['fecha'] !== null && $ticket['fecha'] !== ''): ?>
                    <p>Fecha de uso: <?= htmlspecialchars($ticket['fecha']) ?></p>
                <?php endif; ?>
                <?php if ($ticket['hora_inicio'] !== null && $ticket['hora_inicio'] !== ''): ?>
                    <p>Horario: <?= htmlspecialchars($ticket['hora_inicio']) ?> a <?= htmlspecialchars($ticket['hora_fin']) ?></p>
                <?php endif; ?>
            <?php endif; ?>

            <p class="tarjeta-descripcion"><?= htmlspecialchars($ticket['descripcion']) ?></p>
            <p class="linea-estado">Estado: <span class="estado-chip" data-estado="<?= htmlspecialchars($ticket['estado']) ?>"><?= htmlspecialchars($ticket['estado']) ?></span></p>

            <?php if (puedeHacer("eliminarTickets", $_SESSION["rol"])): ?>
                <form method="post" action="../../Procesos/eliminarticket.php" style="display:inline">
                    <input type="hidden" name="clase" value="<?= htmlspecialchars($ticket['clase']) ?>">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($ticket['id']) ?>">
                    <button type="submit" onclick="return confirm('¿Seguro que quiere eliminar este ticket?')">Eliminar</button>
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