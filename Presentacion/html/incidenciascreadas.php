<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencias Creadas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/incidencias.css">
    <script src="../js/incidencias.js" defer></script>
   
</head>
<body data-modulo="incidencias">
    <header>
       <h1 id="titulo">Incidencias creadas</h1>
        <?php require_once '../globales/Header.php'?>

       

    </header>
    <main>
        <section id="seccion-listado">
            <h3 class="titulo-seccion">Incidencias Registradas</h3>
            <div id="controles">
                <input id="inptbusqueda" name="inptbusqueda" placeholder="Buscar por profesor, tipo, salón, serie...">
                <div id="filtros">
                    <button type="button" class="filtro-clase activo" data-clase="Todos">Todos</button>
                    <button type="button" class="filtro-clase" data-clase="Incidencia">Incidencias</button>
                    <button type="button" class="filtro-clase" data-clase="Solicitud">Solicitudes</button>
                </div>
            </div>
            <ul id="listado-tickets"></ul>
        </section>
    </main>
    <?php include '../globales/Footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>