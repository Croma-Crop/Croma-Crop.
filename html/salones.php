<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salones</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../styles/global.css">
  <link rel="stylesheet" href="../styles/inventario.css">
    <script src="../script/permisos.js" defer></script>
    <script src="../script/script.js" defer></script>
    <script src="../script/salones.js" defer></script>

</head>
<body data-modulo="salones">
    <header>
        <a href="/html/salones.php">
            <?php include '../backend/Header.php'?>
    </a>
        

        <h1 id="titulo">Salones</h1>

    </header>
    <article class="contenedor">
    </article>
    <main>
          <section id="contenido">
            <section id="busqueda">
                <input id="inptbusqueda" name="inptbusqueda" placeholder="Buscar">
            </section>
            <article id="seccion-listado">
                <h3 class="titulo-seccion">Salones registrados:</h3>
                <ul id="listado">
                </ul>
            </article>

            <article id="seccion-formulario">
                <h3 class="titulo-seccion">Ingresar Nuevo Salón</h3>
                <form id="formulario-salon">
                    <input name="nombre" type="text" id="nombreSalon" placeholder="Código del salón (Ej: L3)" required>
                    <button id="submit" type="submit">Guardar Salón</button>
                </form>
            </article>
        </section>
    </main>
    <?php include '../backend/Footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
