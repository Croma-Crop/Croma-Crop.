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
            <p class="ayuda-tablero">Abrí una tarjeta con "Ver más" para tomar la tarea y clasificar su gravedad. Para cambiar el estado, arrastrá la tarjeta a otra columna o usá el selector de la tarjeta.</p>

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
                                    <p class="tarjeta-tipo"><?= htmlspecialchars($ticket['tipo']) ?></p>
                                    <p class="tarjeta-asignado">Técnico: <?= htmlspecialchars($ticket['nombreTecnico']) ?></p>

                                    <button type="button" class="boton-detalle">Ver más</button>

                                    <div class="detalle-ticket">
                                        <?php if ($ticket['clase'] === 'Incidencia'): ?>
                                            <p>Fecha inicio: <?= htmlspecialchars($ticket['fecha']) ?></p>
                                            <p>Equipo: <?= htmlspecialchars($ticket['equipoNombre']) ?></p>
                                            <p>Marca: <?= htmlspecialchars($ticket['equipoMarca']) ?></p>
                                            <p>Modelo: <?= htmlspecialchars($ticket['equipoModelo']) ?></p>
                                            <p>Serie: <?= htmlspecialchars($ticket['numero_serie'] ?? '-') ?></p>
                                            <p>Turno: <?= htmlspecialchars($ticket['turno']) ?></p>
                                        <?php endif; ?>

                                        <?php if ($ticket['clase'] === 'Solicitud'): ?>
                                            <p>Solicitante: <?= htmlspecialchars($ticket['nombreProf']) ?></p>
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

                                        <?php if ($puedeClasificar): ?>
                                            <?php if (!$puedeAsignarTecnico && $ticket['cedula_tecnico'] === null): ?>
                                                <button type="button" class="boton-tomar">Tomar la tarea</button>
                                            <?php endif; ?>

                                            <?php if ($puedeAsignarTecnico): ?>
                                                <label class="campo-kanban">Técnico asignado
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
                                                <label class="campo-kanban">Gravedad
                                                    <select class="select-gravedad">
                                                        <?php foreach (["Sin asignar", "Baja", "Media", "Alta"] as $prioridad): ?>
                                                            <option value="<?= $prioridad ?>" <?= $prioridad === $ticket['prioridad'] ? 'selected' : '' ?>><?= $prioridad ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </label>
                                            <?php endif; ?>

                                            <label class="campo-kanban">Estado
                                                <select class="select-estado">
                                                    <?php foreach (["Pendiente", "En proceso", "Resuelto"] as $estado): ?>
                                                        <option value="<?= $estado ?>" <?= $estado === $ticket['estado'] ? 'selected' : '' ?>><?= $estado ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
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