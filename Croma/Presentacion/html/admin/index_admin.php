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
                    <span class="contador-pendientes"><?= count($todosPendientes) ?></span>
                </header>

                <?php if (empty($todosPendientes)): ?>
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
                                <th>Estado</th>
                            
                                <th class="celda-acciones">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($todosPendientes as $pendiente): 
                                global $pendiente;
                                ?>
                                
                                <tr>
                                    <td class="celda-numerica"><?= htmlspecialchars($pendiente['documento']) ?></td>
                                    <td><?= htmlspecialchars($pendiente['nombre']) ?></td>
                                    <td><?= htmlspecialchars($pendiente['apellido']) ?></td>
                                    <td><?= htmlspecialchars($pendiente['rol']) ?></td>
                                    <td><?= htmlspecialchars($pendiente['estado'])?></td>
                                    <td class="celda-acciones">
                                        <form method="post" action="../../../Procesos/aprobarusuario.php<?= ($pendiente['tipo'] ?? '') === 'extranjero' ? '?tipo=extranjero' : '' ?>" style="display:inline">
                                            <input type="hidden" name="documento" value="<?= htmlspecialchars($pendiente['documento']) ?>">
                                            <input type="hidden" name="accion" value="aprobar">
                                            <button class="btnOperacion" type="submit">Aprobar</button>
                                        </form>
                                        <button type="button" class="btnEliminarEmpleado boton-rechazar" data-id="<?= htmlspecialchars($pendiente['documento']) ?>" data-nombre="<?= htmlspecialchars($pendiente['nombre'] . ' ' . $pendiente['apellido']) ?>" data-tipo="<?= ($pendiente['tipo'] ?? '') === 'extranjero' ? 'extranjero' : '' ?>">Rechazar</button>
                                    </td>
                                </tr>
                            <?php 
                        endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                <?php endif; ?>
            </section>

            <?php if (!empty($todosInactivas)): ?>
            <section class="seccionTablaEmpleados">
                <header class="cajaEncabezado">
                    <h2>Cuentas de baja</h2>
                </header>
                <div class="tabla-envoltorio">
                <table class="tabla-datos">
                    <caption class="subtitulo">Cuentas de baja</caption>
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th>Rol pedido</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($todosInactivas as $inactiva): ?>
                            <tr>
                                <td class="celda-numerica"><?= htmlspecialchars($inactiva['documento']) ?></td>
                                <td><?= htmlspecialchars($inactiva['nombre'] . ' ' . $inactiva['apellido']) ?></td>
                                <td><?= htmlspecialchars($inactiva['rol']) ?></td>
                                <td><form method="post" action="../../../Procesos/aprobarusuario.php<?= ($inactiva['tipo'] ?? '') === 'extranjero' ? '?tipo=extranjero' : '' ?>" style="display:inline">
                                        <input type="hidden" name="documento" value="<?= htmlspecialchars($inactiva['documento']) ?>">
                                        <input type="hidden" name="accion" value="aprobar">
                                        <button class="btnOperacion" type="submit">Dar alta</button>
                                    </form>
                                </td>
                    
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </section>
            <?php endif; ?>

            <?php if (!empty($todosRechazados)): ?>
            <section class="seccionTablaEmpleados">
                <header class="cajaEncabezado">
                    <h2>Solicitudes de cuenta rechazadas</h2>
                </header>
                <div class="tabla-envoltorio">
                <table class="tabla-datos">
                    <caption class="subtitulo">Solicitudes de cuenta rechazadas</caption>
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($todosRechazados as $rechazado): ?>
                            <tr>
                                <td class="celda-numerica"><?= htmlspecialchars($rechazado['documento']) ?></td>
                                <td><?= htmlspecialchars($rechazado['nombre'] . ' ' . $rechazado['apellido']) ?></td>
                                <td><?= htmlspecialchars($rechazado['rol']) ?></td>
                                <td><form method="post" action="../../../Procesos/rechazarusuario.php<?= ($rechazado['tipo'] ?? '') === 'extranjero' ? '?tipo=extranjero' : '' ?>" style="display:inline">
                                        <input type="hidden" name="documento" value="<?= htmlspecialchars($rechazado['documento']) ?>">
                                        <input type="hidden" name="accion" value="borrar">
                                        <button class="btnOperacion" type="submit">Eliminar definitivamente</button>
                                    </form>
                                </td>
                    
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
        <form method="post" action="../../../Procesos/rechazarusuario.php">
            <fieldset>
                <legend>Rechazar solicitud</legend>
                <p id="nombreRechazado"></p>
                <input type="hidden" name="documento" id="idRechazo" value=<?= $pendiente['documento']?>>
                <input type="hidden" name="accion" value="rechazar">
                <div class="cajaEntradaDeDatos">
                    <p for="motivo_rechazo">¿Esta seguro de rechazar esta solicitud?</p>
                    
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
