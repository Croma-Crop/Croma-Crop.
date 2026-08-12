<?php


$scriptPath = $_SERVER['SCRIPT_NAME'];
$posicion = strpos($scriptPath, '/Presentacion/');
$BASE_URL = substr($scriptPath, 0, $posicion);
?>

<!DOCTYPE html>
<html lang="en">
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
        <a href="../../html/admin/index_funcionarios.php">
    <?php include '../../globales/Header.php'?>    
    </a>
       

        <h1 id="titulo">Inicio</h1>

    </header>
    <main>
        <div class="inicio">

            <section class="bienvenida">
                <h2>Sistema de Gestión de Recursos y Soporte de Informática</h2>
                <p>
                    Bienvenido al SGRSI de Croma Corp. Esta plataforma permite registrar y controlar
                    el inventario de equipos, registrar incidencias técnicas mediante tickets y
                    gestionar las solicitudes de servicio del instituto.
                </p>
            </section>

            <h3 class="titulo-modulos">Módulos del sistema</h3>
            <section class="modulos">

                <article class="tarjeta-modulo">
                    <h4>Tickets</h4>
                    <p>Registro de incidencias técnicas y seguimiento de su estado: pendiente, en proceso o resuelto.</p>
                    <a href="<?php echo $BASE_URL ?> /Presentacion/html/tickets.php">Registrar ticket</a>
                </article>

                <article class="tarjeta-modulo">
                    <h4>Incidencias</h4>
                    <p>Listado de las incidencias y solicitudes de servicio creadas en el sistema.</p>
                    <a href="<?php echo $BASE_URL ?>/Presentacion/html/incidenciascreadas.php">Ver incidencias</a>
                </article>
                <article class="tarjeta-modulo">
                    <h4>Ficha</h4>
                    <p>Registro de ficha diaria</p>
                    <a href="ficha.php">Registrar Ficha</a>
                </article>
            </section>

        </div>

    </main>
   <?php include '../../globales/Footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
