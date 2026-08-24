<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGRSI - Ficha | Croma Corp</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/ficha.css">
    <script src="../../js/ficha.js" defer></script>
</head>
<body data-modulo="ficha">
    <header>
        <h1 id="titulo">Ficha</h1>
        <?php include '../../globales/Header.php';
        require '../../../Procesos/mostrarficha.php';
        ?>
    </header>
    <script>
    const usuarioActivo = { nombre: "<?= htmlspecialchars($usuario['nombre']) ?>", apellido: "<?= htmlspecialchars($usuario['apellido']) ?>" };
    </script>
    <main>
        <section id="contenido">
            <section id="seccion-formulario">
                <h3 class="titulo-seccion">Ficha Docente</h3>
                <form id="fichaForm" method="post" action="../../../Procesos/backend/procesoficha.php">
                <div class="camp">    
                <label for="profesor">Profesor</label>
                    <select id="profesor" name="documento_profesor" required>
                        <option value="">--- Seleccionar profesor ---</option>
                        <?php foreach ($profesores as $profesor): ?>
                            <option value="<?= $profesor['documento'] ?>"><?= htmlspecialchars($profesor['nombre'] . ' ' . $profesor['apellido']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    </div>
                    <div class="campo">
                        <label for="fecha_inicio">Fecha</label>
                        <input id="fecha_inicio" type="date" name="fecha" required>
                    </div>

                    <div class="campo-fila">
                        <div class="campo">
                            <label for="hora_entrada">Hora entrada</label>
                            <input type="time" id="hora_entrada" name="hora_entrada" required>
                        </div>

                        <div class="campo">
                            <label for="hora_salida">Hora salida</label>
                            <input type="time" id="hora_salida" name="hora_salida" required>
                        </div>
                    </div>
                    <div class="campo">
                    <label for="salon">Salón</label>
                    <select id="salon" name="id_salon" required>
                        <option value="">--- Seleccionar salón ---</option>
                        <?php foreach ($salones as $salon): ?>
                            <option value="<?= $salon['id_salon'] ?>"><?= htmlspecialchars($salon['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                        </div>
                    <fieldset class="campo grupo-opciones">
                        <legend>Turno</legend>
                        <div class="radio-grupo">
                            <label class="opcion" for="matutino">
                                <input type="radio" id="matutino" name="turno" value="Matutino">
                                <span>Matutino</span>
                            </label>
                            <label class="opcion" for="vespertino">
                                <input type="radio" id="vespertino" name="turno" value="Vespertino">
                                <span>Vespertino</span>
                            </label>
                            <label class="opcion" for="nocturno">
                                <input type="radio" id="nocturno" name="turno" value="Nocturno">
                                <span>Nocturno</span>
                            </label>
                        </div>
                    </fieldset>

                    <button type="submit" id="enviarFicha">Enviar Ficha</button>
                </form>
            </section>

            <section id="seccion-equipos">
                <h3 class="titulo-seccion">Equipos del salón</h3>
                <p id="avisoEquipos">Seleccioná un salón para ver sus equipos.</p>
                <table id="tablaEquipos" class="oculto">
                    <thead>
                        <tr>
                            <th>Incidencia</th>
                            <th>Equipo</th>
                            <th>Serie</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTablaEquipos">
                        <?php foreach ($equipos as $equipo): ?>
                            <tr class="oculto" data-salon="<?= $equipo['id_salon'] ?>" data-serie="<?= $equipo['numero_serie'] ?>" data-nombre="<?= htmlspecialchars($equipo['nombre']) ?>">
                                <td><input type="checkbox" class="check-equipo"></td>
                                <td><?= htmlspecialchars($equipo['nombre']) ?></td>
                                <td><?= htmlspecialchars($equipo['numero_serie']) ?></td>
                                <td><?= htmlspecialchars($equipo['estado']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </section>
    </main>

    <dialog id="dialogIncidencia">
        <form id="formIncidenciaEquipo">
            <h3>Registrar incidencia</h3>
            <p id="equipoSeleccionado"></p>

            <label for="tipoIncidencia">Tipo de incidencia</label>
            <select id="tipoIncidencia" name="tipoIncidencia" required>
                <option value="">--- Seleccionar ---</option>
                <option value="Computadora">Computadora</option>
                <option value="Televisor">Televisor</option>
                <option value="Periferico">Periferico</option>
                <option value="Otro">Otro</option>
            </select>

            <label for="descripcionIncidencia">¿Cuál es la incidencia?</label>
            <input id="descripcionIncidencia" name="descripcionIncidencia" type="text">

            <div class="dialog-acciones">
                <button type="submit" id="guardarIncidenciaEquipo">Guardar</button>
                <button type="button" id="cancelarIncidenciaEquipo">Cancelar</button>
            </div>
        </form>
    </dialog>


    <?php include '../../globales/Footer.html' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>