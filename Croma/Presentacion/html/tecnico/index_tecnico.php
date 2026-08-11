<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGRSI - Inicio Técnico | Croma Corp</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/global.css">
  <link rel="stylesheet" href="../../css/inicio.css">
    <script src="../../js/permisos.js" defer></script>
    <script src="../../js/script.js" defer></script>
    <script src="../../js/tecnico.js" defer></script>

</head>
<body data-modulo="inicio-tecnico">
    <header>
      

        <h1 id="titulo">Inicio</h1>
<?php require_once '../../globales/Header.php'?>
    </header>
    <main>
        <div class="inicio">

            <section class="bienvenida">
                <h2>Panel del técnico</h2>
                <p>
                    Desde acá gestionás el soporte técnico del instituto. En el tablero tomás las tareas
                    registradas por los docentes, les determinás la gravedad y las vas moviendo de estado
                    hasta resolverlas. El listado de incidencias queda como consulta, para que el docente
                    pueda ver en qué anda su incidencia.
                </p>
            </section>

            <h3 class="titulo-modulos">Resumen de trabajo</h3>
            <section class="resumen">

                <article class="tarjeta-resumen">
                    <span class="numero" id="numero-sin-clasificar">0</span>
                    <p>Incidencias sin clasificar</p>
                </article>

                <article class="tarjeta-resumen">
                    <span class="numero" id="numero-pendientes">0</span>
                    <p>Tickets pendientes</p>
                </article>

                <article class="tarjeta-resumen">
                    <span class="numero" id="numero-en-proceso">0</span>
                    <p>Tickets en proceso</p>
                </article>

                <article class="tarjeta-resumen">
                    <span class="numero" id="numero-asignados">0</span>
                    <p>Asignados a mí</p>
                </article>

            </section>

            <h3 class="titulo-modulos">Módulos del sistema</h3>
            <section class="modulos">

                <article class="tarjeta-modulo">
                    <h4>Incidencias</h4>
                    <p>Listado de consulta de las incidencias y solicitudes creadas, con su gravedad, su estado y el técnico que las tiene asignadas.</p>
                    <a href="../../html/incidenciascreadas.php">Ver incidencias</a>
                </article>

                <article class="tarjeta-modulo">
                    <h4>Tablero Kanban</h4>
                    <p>Tomá las tareas, determinales la gravedad y movelas entre pendiente, en proceso y resuelto.</p>
                    <a href="../../html/tecnico/kanban.php">Abrir tablero</a>
                </article>

                <article class="tarjeta-modulo">
                    <h4>Inventario</h4>
                    <p>Control de los equipos del instituto y del historial de intervenciones de cada uno.</p>
                    <a href="../../html/inventario.php">Ver inventario</a>
                </article>

                <article class="tarjeta-modulo">
                    <h4>Tickets</h4>
                    <p>Registro de una nueva incidencia técnica o de una solicitud de servicio.</p>
                    <a href="../../html/tickets.php">Registrar ticket</a>
                </article>

            </section>

        </div>

    </main>
    <?php include '../../globales/Footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
