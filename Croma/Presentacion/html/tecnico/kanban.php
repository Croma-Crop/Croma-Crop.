<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablero Kanban</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/kanban.css">
    <script src="../../js/kanban.js" defer></script>
</head>
<body data-modulo="kanban">
    <header>
        <h1 id="titulo">Tablero Kanban</h1>
        <?php include '../../globales/Header.php'?>
    </header>
    <?php include_once '../../../Procesos/mostrarkanban.php'; ?>
    <main>
        <section id="seccion-tablero">
            <h3 class="titulo-seccion">Asignación y seguimiento de tickets</h3>
            <p class="ayuda-tablero">Abra una tarjeta con 'Ver más' para tomar la tarea y clasificar su gravedad. Para cambiar el estado, arrastre la tarjeta a otra columna o use el selector de la tarjeta.</p>

            <?php if (isset($_GET["mensaje"])): ?>
                <div id="mensaje-kanban" class="mensaje mensaje-<?= ($_GET["tipo"] ?? "") === "exito" ? "exito" : "error" ?>"><?= htmlspecialchars($_GET["mensaje"]) ?></div>
            <?php endif; ?>

            <div id="controles">
                <input id="inptbusqueda" name="inptbusqueda" placeholder="Buscar por profesor, tipo o descripción...">
                <div id="filtros">
                    <button type="button" class="filtro-clase activo" data-clase="Todos">Todos</button>
                    <button type="button" class="filtro-clase" data-clase="Incidencia">Incidencias</button>
                    <button type="button" class="filtro-clase" data-clase="Solicitud">Solicitudes</button>
                </div>
            </div>

            <div class="tablero">
                <?php foreach (["Pendiente", "En proceso", "Resuelto"] as $columna): ?>
                    <section class="columna-kanban" data-estado="<?= $columna ?>">
                        <div class="cabecera-columna">
                            <h4><?= $columna ?></h4>
                            <span class="contador-kanban" data-estado="<?= $columna ?>">
                                <?php
                                    $cantidad = 0;
                                    foreach ($tickets as $ticket) {
                                        if ($ticket['estado'] === $columna) {
                                            $cantidad++;
                                        }
                                    }
                                    echo $cantidad;
                                ?>
                            </span>
                        </div>
                        <ul class="lista-kanban" data-estado="<?= $columna ?>">
                            <?php foreach ($tickets as $ticket): ?>
                                <?php if ($ticket['estado'] !== $columna) continue; ?>
                                <li class="tarjeta-kanban" draggable="true" data-id="<?= htmlspecialchars($ticket['id']) ?>" data-clase="<?= htmlspecialchars($ticket['clase']) ?>" data-estado="<?= htmlspecialchars($ticket['estado']) ?>" data-mi-documento="<?= htmlspecialchars($miDocumento) ?>">
                                    <div class="fila-tarjeta">
                                        <span class="etiqueta-clase etiqueta-<?= strtolower($ticket['clase']) ?>"><?= htmlspecialchars($ticket['clase']) ?></span>
                                        <?php if ($ticket['clase'] === 'Incidencia'): ?>
                                            <span class="gravedad-chip" data-gravedad="<?= htmlspecialchars($ticket['prioridad']) ?>"><?= htmlspecialchars($ticket['prioridad']) ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <p class="tarjeta-nombre"><?= htmlspecialchars($ticket['nombreProf']) ?></p>
                                    <p class="tarjeta-asignado"><span>Técnico:</span> <?= htmlspecialchars($ticket['nombreTecnico']) ?></p>

                                    <button type="button" class="boton-detalle">Ver más</button>

                                    <div class="detalle-ticket">
                                        <?php if ($ticket['clase'] === 'Incidencia'): ?>
                                            <p><span>Fecha de inicio:</span> <?= htmlspecialchars($ticket['fecha']) ?></p>
                                            <p><span>Equipo:</span> <?= htmlspecialchars($ticket['equipoNombre']) ?></p>
                                            <p><span>Marca:</span> <?= htmlspecialchars($ticket['equipoMarca']) ?></p>
                                            <p><span>Modelo:</span> <?= htmlspecialchars($ticket['equipoModelo']) ?></p>
                                            <p><span>Serie:</span> <?= htmlspecialchars($ticket['numero_serie'] ?? '-') ?></p>
                                            <p><span>Turno:</span> <?= htmlspecialchars($ticket['turno']) ?></p>
                                        <?php endif; ?>

                                        <?php if ($ticket['clase'] === 'Solicitud'): ?>
                                            <p><span>Solicitante:</span> <?= htmlspecialchars($ticket['nombreProf']) ?></p>
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

                                        <?php if ($puedeClasificar): ?>
                                            <?php if (!$puedeAsignarTecnico && $ticket['cedula_tecnico'] === null): ?>
                                                <button type="button" class="boton-tomar">Tomar la tarea</button>
                                            <?php endif; ?>

                                            <?php if ($puedeAsignarTecnico): ?>
                                                <label class="campo-kanban"><span>Técnico asignado</span>
                                                    <select class="select-tecnico">
                                                        <option value="">Sin asignar</option>
                                                        <?php foreach ($tecnicos as $tecnico): ?>
                                                            <option value="<?= htmlspecialchars($tecnico['documento']) ?>" <?= $tecnico['documento'] === $ticket['cedula_tecnico'] ? 'selected' : '' ?>><?= htmlspecialchars($tecnico['nombre'] . ' ' . $tecnico['apellido']) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </label>
                                            <?php else: ?>
                                                <?php if ($ticket['cedula_tecnico'] !== null && $ticket['cedula_tecnico'] !== $miDocumento): ?>
                                                    <p class="aviso-kanban">Solo un administrador puede reasignarlo.</p>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if ($ticket['clase'] === 'Incidencia'): ?>
                                                <label class="campo-kanban"><span>Gravedad</span>
                                                    <select class="select-gravedad">
                                                        <?php foreach (["Sin asignar", "Baja", "Media", "Alta"] as $prioridad): ?>
                                                            <option value="<?= $prioridad ?>" <?= $prioridad === $ticket['prioridad'] ? 'selected' : '' ?>><?= $prioridad ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </label>
                                            <?php endif; ?>

                                            <label class="campo-kanban"><span>Estado</span>
                                                <select class="select-estado">
                                                    <?php foreach (["Pendiente", "En proceso", "Resuelto"] as $estado): ?>
                                                        <option value="<?= $estado ?>" <?= $estado === $ticket['estado'] ? 'selected' : '' ?>><?= $estado ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
                                            <?php if($ticket['clase'] === "Incidencia"): ?>
                                            <label class="campo-kanban"><span>Fecha límite</span>
                                            <form method="post" action="../../../Procesos/backend/guardarFechaLimite.php">

                                            <input type="hidden" name="id_incidencia" value="<?= htmlspecialchars($ticket['id']) ?>">
                                            <input type="date" name="fecha" onchange="this.form.submit()">
                                            </form>
                                            </label>
                                            <?php endif;?>
                                            
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <form id="formAccionKanban" method="post" action="../../../Procesos/backend/procesokanban.php">
        <input type="hidden" id="accionId" name="id">
        <input type="hidden" id="accionClase" name="clase">
        <input type="hidden" id="accionCampo" name="campo">
        <input type="hidden" id="accionValor" name="valor">
    </form>

    <?php include '../../globales/Footer.html' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>