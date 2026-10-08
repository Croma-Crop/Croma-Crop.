<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGRSI - Historial | Croma Corp</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/historial.css">
    <script src="../../js/historial.js" defer></script>
</head>
<body data-modulo="historial">
    <header>
        <h1 id="titulo">Historial</h1>
        <?php include '../../globales/Header.php';
        if (file_exists(__DIR__ . '/../../../Procesos/mostrarhistorial.php')) {
            require '../../../Procesos/mostrarhistorial.php';
        } else {
            $usuarios = [
                ["documento" => "11111111", "nombre" => "Guille", "apellido" => "Putito"],
                ["documento" => "22222222", "nombre" => "Carlos", "apellido" => "peruano"]
            ];
            $documentoElegido = $rolSesion === "administrador" ? ($_GET['documento'] ?? '') : $usuario['documento'];
            $fichas = [
                ["fecha" => "2026-10-07", "hora_entrada" => "08:00:00", "hora_salida" => "12:00:00", "salon" => "Salita"],
                ["fecha" => "2026-10-06", "hora_entrada" => "13:00:00", "hora_salida" => "17:30:00", "salon" => "Saloton"],
                ["fecha" => "2026-10-02", "hora_entrada" => "08:00:00", "hora_salida" => "12:00:00", "salon" => "Salonsote"],
                ["fecha" => "2026-09-28", "hora_entrada" => "18:00:00", "hora_salida" => "22:00:00", "salon" => "Salonsito"],
                ["fecha" => "2026-09-21", "hora_entrada" => "08:00:00", "hora_salida" => "11:45:00", "salon" => "LAboratiro"]
            ];
        }
        ?>
    </header>
    <?php
    $nombresMeses = ["01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre"];
    ?>
    <main>
        <section id="seccion-historial">
            <h3 class="titulo-seccion">Historial de fichas diarias</h3>

            <div id="controles">
                <?php if ($rolSesion === "administrador"): ?>
                    <form method="get" class="control">
                        <label for="usuario">Usuario</label>
                        <select id="usuario" name="documento" onchange="this.form.submit()">
                            <option value="">--- Seleccionar usuario ---</option>
                            <?php foreach ($usuarios as $persona): ?>
                                <option value="<?= htmlspecialchars($persona['documento']) ?>" <?= $persona['documento'] === $documentoElegido ? 'selected' : '' ?>><?= htmlspecialchars($persona['nombre'] . ' ' . $persona['apellido']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                <?php endif; ?>

                <?php if (!empty($fichas)): ?>
                    <div class="control">
                        <label for="mes">Mes</label>
                        <select id="mes">
                            <?php $ultimoMes = ""; ?>
                            <?php foreach ($fichas as $ficha): ?>
                                <?php $mes = substr($ficha['fecha'], 0, 7); ?>
                                <?php if ($mes !== $ultimoMes): ?>
                                    <option value="<?= $mes ?>"><?= $nombresMeses[substr($mes, 5, 2)] . ' ' . substr($mes, 0, 4) ?></option>
                                    <?php $ultimoMes = $mes; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($rolSesion === "administrador" && $documentoElegido === ""): ?>
                <p class="aviso">Elegí un usuario para ver su historial.</p>
            <?php elseif (empty($fichas)): ?>
                <p class="aviso">Todavía no hay fichas registradas.</p>
            <?php else: ?>
                <div class="tabla-envoltorio">
                    <table class="tabla-datos">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Salón</th>
                                <th>Entrada</th>
                                <th>Salida</th>
                                <th>Horas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fichas as $ficha): ?>
                                <?php
                                $minutos = (strtotime($ficha['hora_salida']) - strtotime($ficha['hora_entrada'])) / 60;
                                if ($minutos < 0) {
                                    $minutos = $minutos + 1440;
                                }
                                $horas = floor($minutos / 60);
                                $resto = $minutos % 60;
                                ?>
                                <tr data-mes="<?= substr($ficha['fecha'], 0, 7) ?>">
                                    <td><?= date('d/m/Y', strtotime($ficha['fecha'])) ?></td>
                                    <td><?= htmlspecialchars($ficha['salon']) ?></td>
                                    <td><?= substr($ficha['hora_entrada'], 0, 5) ?></td>
                                    <td><?= substr($ficha['hora_salida'], 0, 5) ?></td>
                                    <td class="celda-numerica"><?= $horas ?> h<?= $resto > 0 ? ' ' . $resto . ' min' : '' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <?php include '../../globales/Footer.html' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
