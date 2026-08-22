<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salones</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/inventario.css">
  <script src="../js/salones.js" defer></script>

</head>
<body data-modulo="salones">
    <header>
      
           <h1 id="titulo">Salones</h1>
            <?php include '../globales/Header.php'?>
    
        

        

    </header>
    <article class="contenedor">
    </article>
    <main>
          <section id="contenido">
            <section id="busqueda">
                <form method="post" action="../../Procesos/mostrarsalon.php">
                    <input id="inptbusqueda" name="nombre" type="text" placeholder="Buscar">
                    <button type="submit">Buscar</button>
                </form>
            </section>
            <article id="seccion-listado">
                <h3 class="titulo-seccion">Salones registrados:</h3>
                
                <ul id="listado">
                    <?php include_once "../../Procesos/mostrarsalon.php";
                    foreach ($ok as $claveindexada => $valorindexado) {
                    echo "
             <li class='tarjeta-producto'>
                    <p class='tarjeta-nombre'>" . htmlspecialchars($valorindexado['nombre']) . "</p>
                <div class='tarjetas-acciones'>
                    <a class='boton-modificar' href='?editar=" . $valorindexado['id_salon'] . "'>Modificar</a>
                    <form method='post' action='../../Procesos/eliminarsalon.php' style='display:inline'>
            <input type='hidden' name='id_salon' value='" . $valorindexado['id_salon'] . "'>
                    <button class='boton-eliminar' type='submit' onclick=\"return confirm('¿Seguro que quieres eliminar el salon?')\">Eliminar</button>
                    </form>
                </div>
            </li>
    ";

}
                    
                    
                    ?>
                </ul>
            </article>

            <article id="seccion-formulario">
                 <h3 class="titulo-seccion"><?= $editando ? "Modificar Salón" : "Ingresar Nuevo Salón" ?></h3>
                <form id="formulario-salon" method="post" action="../../Procesos/backend/procesosalones.php">
                    <input name="nombre" type="text" id="nombreSalon" placeholder="Código del salón (Ej: L3)"
                        value="<?= $editando ? htmlspecialchars($editando['nombre']) : '' ?>" required>

                    <select id="tipo" name="tipo" required>
                        <option value="">Seleccione un tipo</option>
                        <option value="taller" <?= ($editando && $editando['tipo'] === 'taller') ? 'selected' : '' ?>>Taller</option>
                        <option value="laboratorio" <?= ($editando && $editando['tipo'] === 'laboratorio') ? 'selected' : '' ?>>Laboratorio</option>
                    </select>

                    <input type="hidden" name="id_salon" value="<?= $editando ? $editando['id_salon'] : '' ?>">

                    <button id="submit" type="submit">Guardar Salón</button>
                </form>
                <?php if (isset($_GET["mensaje"])): ?>
             <div class="mensaje mensaje-<?= ($_GET["tipo"] ?? "") === "exito" ? "exito" : "error" ?>">
                 <?= htmlspecialchars($_GET["mensaje"]) ?>
             </div>
                 <?php endif; ?>
            </article>
        </section>
    </main>
    <?php include '../globales/Footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
