<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGRSI - Inicio | Croma Corp</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/global.css">
  <link rel="stylesheet" href="../../css/inicio.css">
  <link rel="stylesheet" href="../../css/admin.css">
    <script src="../../js/registrospendientes.js" defer></script>
 

</head>
<body data-modulo="index_admin">
    
   
    <header>
       <h1 id="titulo">Inicio</h1>

<?php require_once '../../globales/Header.php'?>

        
    </header>
    <?php require_once '../../../Procesos/mostrarsolicitudesusuario.php'; ?>
    <main>
        <div class="inicio">

            <section class="bienvenida">
                <h2>Panel del administrador</h2>
                <p>
                    Desde acá administrás el sistema: el alta y baja de empleados, el inventario de
                    equipos y los salones del instituto. Usá el menú para entrar a cada módulo.
                </p>
            </section>

            <?php if (isset($_GET["mensaje"])): ?>
                <div class="mensaje mensaje-<?= ($_GET["tipo"] ?? "") === "exito" ? "exito" : "error" ?>">
                    <?= htmlspecialchars($_GET["mensaje"]) ?>
                </div>
            <?php endif; ?>

            <section class="seccionTablaEmpleados">
                <header class="cajaEncabezado">
                    <h2>Solicitudes de registro pendientes</h2>
                    <span class="contador-pendientes"><?= count($solicitudesPendientes) ?></span>
                </header>

                <?php if (empty($solicitudesPendientes)): ?>
                    <p class="ayuda-panel">No hay solicitudes pendientes.</p>
                <?php else: ?>
                    <div class="tabla-envoltorio">
                    <table class="tabla-datos">
                        <caption class="subtitulo">Solicitudes de registro sin resolver</caption>
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Rol pedido</th>
                                <th>Motivo</th>
                                <th>Fecha</th>
                                <th class="celda-acciones">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($solicitudesPendientes as $pendiente): ?>
                                <tr>
                                    <td class="celda-numerica"><?= htmlspecialchars($pendiente['documento']) ?></td>
                                    <td><?= htmlspecialchars($pendiente['nombre']) ?></td>
                                    <td><?= htmlspecialchars($pendiente['apellido']) ?></td>
                                    <td><?= htmlspecialchars($pendiente['rol_pedido']) ?></td>
                                    <td><?= htmlspecialchars($pendiente['motivo']) ?></td>
                                    <td><?= htmlspecialchars($pendiente['fecha']) ?></td>
                                    <td class="celda-acciones">
                                        <form method="post" action="../../../Procesos/aprobarusuario.php" style="display:inline">
                                            <input type="hidden" name="id_solicitud_usuario" value="<?= htmlspecialchars($pendiente['id_solicitud_usuario']) ?>">
                                            <input type="hidden" name="accion" value="aprobar">
                                            <button class="btnOperacion" type="submit">Aprobar</button>
                                        </form>
                                        <button type="button" class="btnEliminarEmpleado boton-rechazar" data-id="<?= htmlspecialchars($pendiente['id_solicitud_usuario']) ?>" data-nombre="<?= htmlspecialchars($pendiente['nombre'] . ' ' . $pendiente['apellido']) ?>">Rechazar</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                <?php endif; ?>
            </section>

            <?php if (!empty($solicitudesResueltas)): ?>
            <section class="seccionTablaEmpleados">
                <header class="cajaEncabezado">
                    <h2>Solicitudes ya resueltas</h2>
                </header>
                <div class="tabla-envoltorio">
                <table class="tabla-datos">
                    <caption class="subtitulo">Solicitudes de registro ya resueltas</caption>
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th>Rol pedido</th>
                            <th>Estado</th>
                            <th>Resuelta por</th>
                            <th>Motivo del rechazo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($solicitudesResueltas as $resuelta): ?>
                            <tr>
                                <td class="celda-numerica"><?= htmlspecialchars($resuelta['documento']) ?></td>
                                <td><?= htmlspecialchars($resuelta['nombre'] . ' ' . $resuelta['apellido']) ?></td>
                                <td><?= htmlspecialchars($resuelta['rol_pedido']) ?></td>
                                <td><span class="estado-chip" data-estado="<?= htmlspecialchars($resuelta['estado']) ?>"><?= htmlspecialchars($resuelta['estado']) ?></span></td>
                                <td><?= htmlspecialchars($resuelta['nombre_administrador'] ? $resuelta['nombre_administrador'] . ' ' . $resuelta['apellido_administrador'] : '-') ?></td>
                                <td><?= htmlspecialchars($resuelta['motivo_rechazo'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </section>
            <?php endif; ?>

        </div>
    </main>

    <dialog id="dialogRechazo" class="dialogGestionarEmpleado seccionFormulario">
        <form method="post" action="../../../Procesos/aprobarusuario.php">
            <fieldset>
                <legend>Rechazar solicitud</legend>
                <p id="nombreRechazado"></p>
                <input type="hidden" name="id_solicitud_usuario" id="idRechazo">
                <input type="hidden" name="accion" value="rechazar">
                <div class="cajaEntradaDeDatos">
                    <label for="motivo_rechazo">Motivo del rechazo</label>
                    <input type="text" id="motivo_rechazo" name="motivo_rechazo" placeholder="Ej: no figura como docente del instituto" required>
                </div>
                <button type="submit">Rechazar solicitud</button>
                <button type="button" id="cancelarRechazo">Cancelar</button>
            </fieldset>
        </form>
    </dialog>
    <?php include '../../globales/Footer.html' ?>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
