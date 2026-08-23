
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/tickets.css">
    <title>Tickets</title>

    <script src="../js/tickets.js" defer></script>
</head>

<body data-modulo="tickets">

    <header>
        <h1 id="titulo">Incidencias y Solicitudes</h1>
        
             <?php include '../globales/Header.php'?>
    
        

        

    </header>
<?php require '../../Procesos/backend/cargarinventario.php'; ?>
    <script>
    const nombreCompleto = "<?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']) ?>";
    </script>

    <main>
        <section id="newsletter">
            <form id="formularioNewsletter">
                <p id="paragraph"><strong>¿Que quiere registrar?</strong></p>

                <div id="campo-documento">
                    <button type="button" id="incidencia">Incidencia</button>
                    <button type="button" id="regSolicitud">Solicitudes</button>
                </div>
            </form>
        </section>
        <section class="contenedor mostrar">
       
    <form id="incforms" method="post" action="../../Procesos/backend/procesoincidencia.php">
        <h3>Incidencias</h3>

        <label for="fecha">Fecha</label>
        <input id="fecha_inicio" type="date" name="fecha">

        <label for="salon">Salon:</label>
        <select id="salon" name="salon" required onchange="this.form.action='tickets.php'; this.form.submit();">
            <option value="">--- Seleccionar salón ---</option>
            <?php foreach ($salones as $salon): ?>
                <option value="<?= $salon['id_salon'] ?>" <?= ($salonElegido == $salon['id_salon']) ? 'selected' : '' ?>><?= htmlspecialchars($salon['nombre']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="serie">Equipo del salón:</label>
        <select id="serie" name="serie" required>
            <?php if (empty($equiposDelSalon)): ?>
                <option value="">--- Seleccione un salón primero ---</option>
            <?php else: ?>
                <option value="">--- Seleccionar equipo ---</option>
                <?php foreach ($equiposDelSalon as $equipo): ?>
                    <option value="<?= $equipo['numero_serie'] ?>"><?= htmlspecialchars($equipo['nombre']) ?> (Serie: <?= $equipo['numero_serie'] ?>)</option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <p>Turno:</p>
        <section class="radio-grupo">
            <input type="radio" id="matutino" name="turno" value="matutino">
            <label for="matutino">Matutino</label>
            <input type="radio" id="vespertino" name="turno" value="vespertino">
            <label for="vespertino">Vespertino</label>
            <input type="radio" id="nocturno" name="turno" value="nocturno">
            <label for="nocturno">Nocturno</label>
        </section>

        <p>Tipo de incidencia</p>
        <select id="tipo" name="tipo" required>
            <option value="">---Seleccionar---</option>
            <option value="Computadora">Computadora</option>
            <option value="Televisor">Televisor</option>
            <option value="Periferico">Periferico</option>
            <option value="Otro">Otro</option>
        </select>

        <p>¿Cual es la incidencia?</p>
        <input id="descripcioninc" name="descripcion">

        <button id="enviarinc" type="submit">Enviar Incidencia</button>
        <button type="button" id="volverInc">Volver</button>
    </form>
        
            </section>
            <section class="contenedorSol mostrar">
        <form id="solforms" method="post" action="../../Procesos/backend/procesosolicitud.php">
            <h3>Solicitudes</h3>
            <label for="tipoSol">¿Tipo de solicitud?</label>
            <select id="tipoSol" name="tipo" required>
                <option value="">---Seleccionar---</option>
                <option value="Instalacion de Software">Instalacion de Software</option>
                <option value="Reserva de Salon">Reserva de Salon</option>
            </select>
            <label for="salonSol">Salón:</label>
            <select id="salonSol" name="id_salon" required>
                <option value="">--- Seleccionar salón ---</option>
                <?php foreach ($salones as $salon): ?>
                    <option value="<?= $salon['id_salon'] ?>"><?= htmlspecialchars($salon['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
            <label for="descripcionSol">Descripcion de la Solicitud:</label>
            <input type="text" id="descripcionSol" name="descripcion">
            <button id="enviarSol" type="submit">Enviar Solicitud</button>
            <button type="button" id="volverSol">Volver</button>
        </form>
        </section>
    </main>

    <?php include '../globales/Footer.php' ?> 


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>