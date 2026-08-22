<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/inventario.css">
    <script src="../js/inventario.js" defer></script>
   
</head>
<body data-modulo="inventario">
<header>  
   <h1 id="titulo">Inventario</h1>
 <?php require '../globales/Header.php'?>


</header>
    <article class="contenedor">
    </article>
    <main>
          <section id="contenido">
            <section id="busqueda">
                <form method="post" action="../../Procesos/busquedainventario.php">
                <input id="inptbusqueda" name="nombre" placeholder="Buscar">
                <button type="submit">Buscar</button>
                </form>
            </section>
            <article id="seccion-listado">
                <h3 class="titulo-seccion">Inventario de equipos:</h3>
                <ul id="listado">
                    <?php 
                    include_once '../../Procesos/mostrarinventario.php';
                    ?>
                   <?php foreach ($salones as $salon): ?>
                    
                <?php endforeach; ?>
                </ul>


                
                        <ul id="listado-equipos">
        <?php foreach ($equipos as $equipo): ?>
            <li class="tarjeta-producto">
                <p class="tarjeta-nombre"><?= htmlspecialchars($equipo['nombre']) ?></p>
                <p class="tarjeta-marca">Marca: <?= htmlspecialchars($equipo['marca']) ?></p>
                <p class="tarjeta-serie">Serie: <?= htmlspecialchars($equipo['numero_serie']) ?></p>
                <p class="tarjeta-modelo">Modelo: <?= htmlspecialchars($equipo['modelo']) ?></p>
                <p class="tarjeta-estado">Estado: <?= htmlspecialchars($equipo['estado']) ?></p>
                <p class="tarjeta-salon">Salon: <?= htmlspecialchars($equipo['nombre_salon'] ?? 'Sin asignar') ?></p>
                <p class="tarjeta-intervenciones">Intervenciones: <?= $equipo['numero_intervenciones'] ?></p>
                <div class="tarjeta-acciones">
                    <form method="post" action="../../Procesos/registrarintervencion.php">
                        <input type="hidden" name="numero_serie" value="<?= $equipo['numero_serie'] ?>">
                    <a class="boton-historial" href="?historial=<?= $equipo['numero_serie'] ?>">Ver historial</a>
                    </form>
                    <form>
                    <a class="boton-modificar" href="?editar=<?= $equipo['numero_serie'] ?>">Modificar</a>
                    </form>
                    <form method="post" action="../../Procesos/eliminarinventario.php" style="display:inline">
                        <input type="hidden" name="numero_serie" value="<?= $equipo['numero_serie'] ?>">
                        <button class="boton-eliminar" type="submit" onclick="return confirm('¿Seguro que quiere eliminar este equipo?')">Eliminar</button>
                    </form>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
                    

                    
                    
                    
              
            </article>

            <article id="seccion-formulario">
                <h3 class="titulo-seccion"><?= $editando ? "Modificar Equipo" : "Ingresar Nuevo Equipo" ?></h3>
                <form id="formulario-producto" method="post" action="../../Procesos/backend/procesoinventario.php">
                    <input name="nombre" type="text" id="nombre" placeholder="Nombre del artículo" required value="<?= $editando ? htmlspecialchars($editando['nombre']) : '' ?>">
                    <input name="marca" type="text" id="marca" placeholder="Marca del articulo" required value="<?= $editando ? htmlspecialchars($editando['marca']) : '' ?>">
                    <input name="numero_serie" type="text" class="numSerie" placeholder="Numero de Serie" required value="<?= $editando ? htmlspecialchars($editando['numero_serie']) : '' ?>" <?= $editando ? 'readonly' : '' ?>>
                    <input name="modelo" type="text" class="numSerie" placeholder="Modelo" required value="<?= $editando ? htmlspecialchars($editando['modelo']) : '' ?>">
                    <select name="estado" id="estado" required>
                        <option value="">--- Seleccionar estado ---</option>
                        <option value="operativo" <?= ($editando && $editando['estado'] === 'operativo') ? 'selected' : '' ?>>Operativo</option>
                        <option value="en_reparacion" <?= ($editando && $editando['estado'] === 'en_reparacion') ? 'selected' : '' ?>>En reparación</option>
                        <option value="de_baja" <?= ($editando && $editando['estado'] === 'de_baja') ? 'selected' : '' ?>>De baja</option>
                        <option value="prestado" <?= ($editando && $editando['estado'] === 'prestado') ? 'selected' : '' ?>>Prestado</option>
                    </select>
                    <input type="hidden" name="esEdicion" value="<?= $editando ? '1' : '' ?>">
                    <select name="id_salon" id="salonInventario" required>
                        <option value="">--- Asignar a un salón ---</option>
                        <?php foreach ($salones as $salon): ?>
                        <option value="<?= $salon['id_salon'] ?>" <?= ($editando && $editando['id_salon'] == $salon['id_salon']) ? 'selected' : '' ?>><?= htmlspecialchars($salon['nombre']) ?></option>  
                        <?php endforeach; ?>
                    </select>
                    <button id="submit" type="submit">Guardar Artículo</button>
                </form>
                <?php if (isset($_GET["mensaje"])): ?>
                <div class="mensaje">
                    <?= htmlspecialchars($_GET["mensaje"]) ?>
                </div>
                <?php endif; ?>
            </article>
        </section>

                    <dialog id="dialogHistorial" <?= $numeroSerieHistorial ? 'open' : '' ?>>
                    <button id="cerrarHistorial" type="button" onclick="document.getElementById('dialogHistorial').close()">Cerrar</button>
                    <h3 id="tituloHistorial">Historial de intervenciones — Serie: <?= htmlspecialchars($numeroSerieHistorial ?? '') ?></h3>

                    <ul id="listaHistorial">
                        <?php if (empty($historial)): ?>
                            <li>Este equipo todavía no tuvo intervenciones.</li>
                        <?php else: ?>
                            <?php foreach ($historial as $h): ?>
                                <li class="item-historial">
                                    <p><strong><?= htmlspecialchars($h['fecha']) ?></strong> — <?= htmlspecialchars($h['descripcion']) ?></p>
                                    <p>Técnico: <?= htmlspecialchars($h['tecnico'] ?? '-') ?></p>
                                    <p>Solución: <?= htmlspecialchars($h['solucion'] ?? 'Pendiente') ?></p>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>

                    <?php if ($numeroSerieHistorial): ?>
                        <form method="post" action="../../Procesos/registrarintervencion.php">
                            <input type="hidden" name="numero_serie" value="<?= htmlspecialchars($numeroSerieHistorial) ?>">
                            <label for="fecha">Fecha</label>
                            <input type="date" name="fecha" id="fecha">
                            <label for="descripcion">Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" required>
                            <button type="submit">Registrar intervención</button>
                        </form>
                    <?php endif; ?>
                </dialog>
    </main>
        <?php include '../globales/Footer.php' ?>   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>