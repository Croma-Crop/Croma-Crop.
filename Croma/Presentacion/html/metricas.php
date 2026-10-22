<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGRSI - Métricas | Croma Corp</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/metricas.css">
</head>
<body data-modulo="metricas">
    <header>
        <h1 id="titulo">Métricas</h1>
        <?php include '../globales/Header.php'; ?>
    </header>
    <?php include_once '../../Procesos/mostrarmetricas.php'; ?>
    <?php
    $nombresEquipos = [];
    $totalesEquipos = [];
    foreach ($equiposFallas as $equipo) {
        $nombresEquipos[] = $equipo['nombre'] . ' (' . $equipo['nombre_salon'] . ')';
        $totalesEquipos[] = $equipo['numero_intervenciones'];
    }
    ?>
    <main>
        <div class="metricas">

            <section class="panel-metrica">
                <h2 class="titulo-seccion">Equipos con más fallas</h2>
                <p class="subtitulo">Los 10 equipos con más incidencias registradas.</p>

                <?php if (empty($equiposFallas)): ?>
                    <p class="aviso">Todavía no hay incidencias registradas.</p>
                <?php else: ?>
                    <div class="contenedor-grafico">
                        <canvas id="grafico-equipos"></canvas>
                    </div>
                <?php endif; ?>
            </section>

            <section class="panel-metrica">
                <div class="encabezado-metrica">
                    <h2 class="titulo-seccion">Incidencias vencidas</h2>
                    <span class="contador-vencidas"><?= count($vencidas) ?></span>
                </div>
                <p class="subtitulo">Incidencias con la fecha límite pasada que todavía no se resolvieron.</p>

                <?php if (empty($vencidas)): ?>
                    <p class="aviso">No hay incidencias vencidas.</p>
                <?php else: ?>
                    <div class="tabla-envoltorio">
                        <table class="tabla-datos">
                            <thead>
                                <tr>
                                    <th>Incidencia</th>
                                    <th>Equipo</th>
                                    <th>Salón</th>
                                    <th>Gravedad</th>
                                    <th>Técnico</th>
                                    <th>Fecha límite</th>
                                    <th>Días de atraso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($vencidas as $vencida): ?>
                                    <tr>
                                        <td>#<?= $vencida['id_incidencia'] ?></td>
                                        <td><?= htmlspecialchars($vencida['equipo'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($vencida['salon'] ?? '-') ?></td>
                                        <td><span class="gravedad-chip" data-gravedad="<?= htmlspecialchars($vencida['prioridad']) ?>"><?= htmlspecialchars($vencida['prioridad']) ?></span></td>
                                        <td><?= htmlspecialchars($vencida['tecnico']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($vencida['fecha_limite'])) ?></td>
                                        <td class="celda-numerica"><?= $vencida['dias_atraso'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>

        </div>
    </main>

    <?php include '../globales/Footer.html' ?>
    <script>
        var nombresEquipos = <?= json_encode($nombresEquipos) ?>;
        var totalesEquipos = <?= json_encode($totalesEquipos) ?>;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.js"></script>
    <script src="../js/metricas.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
