<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salones</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/inventario.css">
  <script src="../js/apisalon.js" defer></script>
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
                <h3 class="titulo-seccion titulo-busqueda">Buscar salón</h3>
                <form method="post" action="../../Procesos/mostrarsalon.php">
                    <input id="inptbusqueda" name="nombre" type="text" placeholder="Buscar">
                    <button type="submit">Buscar</button>
                </form>
            </section>
            <article id="seccion-listado">
                <h3 class="titulo-seccion">Salones registrados:</h3>
                <ul id="listado">
                    <?php
                    include_once "../../Procesos/mostrarsalon.php";
                    foreach ($ok as $valorindexado) {
                        $idSalon     = htmlspecialchars($valorindexado['id_salon'], ENT_QUOTES);
                        $nombreSalon = htmlspecialchars($valorindexado['nombre'], ENT_QUOTES);
                        $tipoSalon   = htmlspecialchars($valorindexado['tipo'], ENT_QUOTES);
                        echo "
                        <li class='tarjeta-producto' data-id='{$idSalon}'>
                            <p class='tarjeta-nombre'>{$nombreSalon}</p>
                            <div class='tarjeta-acciones'>
                                <button type='button' class='boton-modificar'
                                        data-id='{$idSalon}' data-nombre='{$nombreSalon}' data-tipo='{$tipoSalon}'>Modificar</button>
                                <button type='button' class='boton-eliminar'
                                        data-id='{$idSalon}'>Eliminar</button>
                            </div>
                        </li>";
                    }
                    ?>
                </ul>
            </article>
            <article id="seccion-formulario">
                <h3 class="titulo-seccion" id="titulo-formulario">Ingresar Nuevo Salón</h3>
                <form id="formulario-salon">
                    <input name="nombre" type="text" maxlength="30" id="nombreSalon"
                           placeholder="Código del salón (ej.: L3)" required>
                    <select id="tipo" name="tipo" required>
                        <option value="">Seleccione un tipo</option>
                        <option value="taller">Taller</option>
                        <option value="laboratorio">Laboratorio</option>
                    </select>
                    <input type="hidden" name="id_salon" id="idSalon" value="">
                    <button id="submit" type="submit">Guardar salón</button>
                    <button type="button" id="cancelarSalon" hidden>Cancelar</button>
                </form>
                <div id="mensaje" class="mensaje" hidden></div>
            </article>
        </section>
    </main>
    <?php include '../globales/Footer.html' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
