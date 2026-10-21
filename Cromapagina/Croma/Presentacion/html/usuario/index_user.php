<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGRSI - Inicio | Croma Corp</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/global.css">
  <link rel="stylesheet" href="../../css/inicio.css">
</head>
<body data-modulo="inicio-user">
    <header>
        <h1 id="titulo">Inicio</h1>
        <?php include '../../globales/Header.php' ?>
    </header>
    <?php require_once '../../../Procesos/backend/cargarincidenciascreadas.php'; ?>
    <?php
    $miDocumento = $_SESSION['usuarioActivo']['documento'];
    $misTickets = [];

    foreach ($incidencias as $incidencia) {
        if ($incidencia['cedula_solicitante'] === $miDocumento && count($misTickets) < 5) {
            $misTickets[] = ['clase' => 'Incidencia', 'tipo' => '-', 'estado' => $incidencia['estado']];
        }
    }

    foreach ($solicitudes as $solicitud) {
        if ($solicitud['cedula_solicitante'] === $miDocumento && count($misTickets) < 5) {
            $misTickets[] = ['clase' => 'Solicitud', 'tipo' => $solicitud['tipo'], 'estado' => $solicitud['estado']];
        }
    }
    ?>
    <main>
        <div class="inicio">

            <section class="bienvenida">
                <h2>Bienvenido</h2>
                <p>¿Qué desea hacer hoy?</p>
            </section>

            <section class="acciones-principales">
                <a class="boton-grande boton-grande-principal" href="../tickets.php">Reportar un problema</a>
                <a class="boton-grande" href="ficha.php">Registrar ficha de hoy</a>
            </section>

            <h3 class="titulo-modulos">Mis tickets</h3>
            <?php if (empty($misTickets)): ?>
                <p class="aviso-inicio">Todavía no registró ningún ticket.</p>
            <?php else: ?>
                <div class="tabla-envoltorio">
                    <table class="tabla-datos">
                        <thead>
                            <tr>
                                <th>Clase</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($misTickets as $miTicket): ?>
                                <tr>
                                    <td><?= htmlspecialchars($miTicket['clase']) ?></td>
                                    <td><?= htmlspecialchars($miTicket['tipo']) ?></td>
                                    <td><span class="estado-chip" data-estado="<?= htmlspecialchars($miTicket['estado']) ?>"><?= htmlspecialchars($miTicket['estado']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <h3 class="titulo-modulos">Otros accesos</h3>
            <section class="accesos">
                <a class="acceso" href="../incidenciascreadas.php">
                    <h4>Tickets creados</h4>
                    <p>Listado de las incidencias y solicitudes del instituto.</p>
                </a>
                <a class="acceso" href="historial.php">
                    <h4>Historial</h4>
                    <p>Las fichas diarias que registró, ordenadas por mes.</p>
                </a>
            </section>

        </div>
    </main>
    <?php include '../../globales/Footer.html' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>