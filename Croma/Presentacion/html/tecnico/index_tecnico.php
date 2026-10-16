<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGRSI - Inicio técnico | Croma Corp</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/global.css">
  <link rel="stylesheet" href="../../css/inicio.css">
</head>
<body data-modulo="inicio-tecnico">
    <header>
        <h1 id="titulo">Inicio</h1>
        <?php require_once '../../globales/Header.php' ?>
    </header>
    <?php require_once '../../../Procesos/backend/cargarincidenciascreadas.php'; ?>
    <?php
    $miDocumento = $_SESSION['usuarioActivo']['documento'];
    $sinClasificar = 0;
    $pendientes = 0;
    $enProceso = 0;
    $misTareas = [];

    foreach ($incidencias as $incidencia) {
        if ($incidencia['prioridad'] === 'Sin asignar' && $incidencia['estado'] !== 'Resuelto') {
            $sinClasificar = $sinClasificar + 1;
        }
        if ($incidencia['estado'] === 'Pendiente') {
            $pendientes = $pendientes + 1;
        }
        if ($incidencia['estado'] === 'En proceso') {
            $enProceso = $enProceso + 1;
        }
        if ($incidencia['cedula_tecnico'] === $miDocumento && $incidencia['estado'] !== 'Resuelto') {
            $misTareas[] = ['clase' => 'Incidencia', 'tipo' => $incidencia['tipo'], 'prioridad' => $incidencia['prioridad'], 'fecha_limite' => $incidencia['fecha_limite'], 'estado' => $incidencia['estado']];
        }
    }

    foreach ($solicitudes as $solicitud) {
        if ($solicitud['estado'] === 'Pendiente') {
            $pendientes = $pendientes + 1;
        }
        if ($solicitud['estado'] === 'En proceso') {
            $enProceso = $enProceso + 1;
        }
        if ($solicitud['cedula_tecnico'] === $miDocumento && $solicitud['estado'] !== 'Resuelto') {
            $misTareas[] = ['clase' => 'Solicitud', 'tipo' => $solicitud['tipo'], 'prioridad' => null, 'fecha_limite' => null, 'estado' => $solicitud['estado']];
        }
    }
    ?>
    <main>
        <div class="inicio">

            <section class="bienvenida">
                <h2>Panel del técnico</h2>
                <p>Desde aquí gestiona el soporte técnico del instituto. En el tablero toma las tareas, determina su gravedad y las cambia de estado hasta resolverlas.</p>
            </section>

            <h3 class="titulo-modulos">Resumen de trabajo</h3>
            <section class="resumen">
                <article class="tarjeta-resumen">
                    <span class="numero"><?= $sinClasificar ?></span>
                    <p>Incidencias sin clasificar</p>
                </article>

                <article class="tarjeta-resumen">
                    <span class="numero"><?= $pendientes ?></span>
                    <p>Tickets pendientes</p>
                </article>

                <article class="tarjeta-resumen">
                    <span class="numero"><?= $enProceso ?></span>
                    <p>Tickets en proceso</p>
                </article>

                <article class="tarjeta-resumen">
                    <span class="numero"><?= count($misTareas) ?></span>
                    <p>Asignados a mí</p>
                </article>
            </section>

            <h3 class="titulo-modulos">Mis tareas</h3>
            <?php if (empty($misTareas)): ?>
                <p class="aviso-inicio">No tiene tareas asignadas.</p>
            <?php else: ?>
                <div class="tabla-envoltorio">
                    <table class="tabla-datos">
                        <thead>
                            <tr>
                                <th>Clase</th>
                                <th>Tipo</th>
                                <th>Gravedad</th>
                                <th>Fecha límite</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($misTareas as $tarea): ?>
                                <tr>
                                    <td><?= htmlspecialchars($tarea['clase']) ?></td>
                                    <td><?= htmlspecialchars($tarea['tipo']) ?></td>
                                    <td>
                                        <?php if ($tarea['prioridad'] === null): ?>
                                            -
                                        <?php else: ?>
                                            <span class="gravedad-chip" data-gravedad="<?= htmlspecialchars($tarea['prioridad']) ?>"><?= htmlspecialchars($tarea['prioridad']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($tarea['fecha_limite'] === null): ?>
                                            -
                                        <?php else: ?>
                                            <?= date('d/m/Y', strtotime($tarea['fecha_limite'])) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><span class="estado-chip" data-estado="<?= htmlspecialchars($tarea['estado']) ?>"><?= htmlspecialchars($tarea['estado']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <h3 class="titulo-modulos">Accesos</h3>
            <section class="accesos">
                <a class="acceso" href="kanban.php">
                    <h4>Tablero Kanban</h4>
                    <p>Tome las tareas y muévalas entre pendiente, en proceso y resuelto.</p>
                </a>
                <a class="acceso" href="../incidenciascreadas.php">
                    <h4>Tickets creados</h4>
                    <p>Listado de consulta con la gravedad, el estado y el técnico de cada ticket.</p>
                </a>
                <a class="acceso" href="../inventario.php">
                    <h4>Inventario</h4>
                    <p>Control de los equipos y de su historial de intervenciones.</p>
                </a>
                <a class="acceso" href="../tickets.php">
                    <h4>Tickets</h4>
                    <p>Registro de una nueva incidencia o de una solicitud de servicio.</p>
                </a>
            </section>

        </div>
    </main>
    <?php include '../../globales/Footer.html' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
