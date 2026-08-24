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
        <li class="tarjeta-ticket">
            <p class="tarjeta-clase tarjeta-<?= strtolower($ticket['clase']) ?>"><?= $ticket['clase'] ?></p>
            <p class="tarjeta-tipo">Tipo: <?= htmlspecialchars($ticket['tipo']) ?></p>

            <?php if ($ticket['clase'] === 'Incidencia'): ?>
                <p>Fecha: <?= htmlspecialchars($ticket['fecha']) ?></p>
                <p>Turno: <?= htmlspecialchars($ticket['turno']) ?></p>
                <p class="tarjeta-prioridad">Prioridad: <?= htmlspecialchars($ticket['prioridad']) ?></p>
            <?php endif; ?>

            <p class="tarjeta-descripcion"><?= htmlspecialchars($ticket['descripcion']) ?></p>
            <p class="linea-estado">Estado: <span class="estado-chip" data-estado="<?= htmlspecialchars($ticket['estado']) ?>"><?= htmlspecialchars($ticket['estado']) ?></span></p>

            <?php if (puedeHacer("eliminarTickets", $_SESSION["rol"])): ?>
                <form method="post" action="../../Procesos/eliminarticket.php" style="display:inline">
                    <input type="hidden" name="clase" value="<?= $ticket['clase'] ?>">
                    <input type="hidden" name="id" value="<?= $ticket['id'] ?>">
                    <button type="submit" onclick="return confirm('¿Seguro que quiere eliminar este ticket?')">Eliminar</button>
                </form>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
<?php endif; ?>




            </ul>
        </section>
    </main>
    <?php include '../globales/Footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>