<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/registro.css">
    <title>Solicitar usuario</title>
    <script src="../js/registro.js" defer></script>
</head>

<body>
    <header>
        <a href="../index.php">
            <img src="../img/removebg-preview.png" alt="Logo Croma Corp" id="logo">
        </a>

        <div class="acciones-header">
            <button class="btn-idioma" type="button" id="btn-idioma">EN</button>
        </div>

        <script src="../js/idioma.js"></script>

    </header>
    <main>
        <section id="newsletter">
            <form id="formularioRegistro" method="post" action="../../Procesos/backend/procesoregistro.php">
                <h1>Solicitar usuario</h1>

                <p class="aviso-registro">Un administrador tiene que aprobar la solicitud antes de darle acceso.</p>

                <?php if (isset($_GET["mensaje"])): ?>
                    <div class="mensaje mensaje-<?= ($_GET["tipo"] ?? "") === "exito" ? "exito" : "error" ?>">
                        <?= htmlspecialchars($_GET["mensaje"]) ?>
                    </div>
                <?php endif; ?>

                <section id="campo-documento">
                    <label for="cedula">Cédula</label>
                    <input type="text" id="cedula" name="documento" placeholder="Ingrese su cédula" pattern="[1-9][0-9]{7}" title="Ingrese exactamente 8 dígitos sin puntos ni guiones" inputmode="numeric" maxlength="8" required>
                    <p id="mensaje" class="mensaje-error"></p>
                </section>

                <div id="campo-boton">
                    <button id="extranjero">Si es extranjero, haga clic aquí</button>
                </div>

                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre" autocomplete="given-name" maxlength="50" required>

                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" placeholder="Ingrese su apellido" autocomplete="family-name" maxlength="50" required>

                <label for="rol_pedido">Rol que le corresponde</label>
                <select id="rol_pedido" name="rol_pedido" required>
                    <option value="">--- Seleccionar rol ---</option>
                    <option value="solicitante">Solicitante (docente)</option>
                    <option value="tecnico">Técnico</option>
                    <option value="administrador">Administrador</option>
                </select>

                <label for="motivo">¿Para qué necesita el usuario?</label>
                <input type="text" id="motivo" name="motivo" placeholder="Ej.: soy docente de 3ro" required>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="contrasena" placeholder="Al menos 8 caracteres" minlength="8" required>

                <label for="password2">Repetir contraseña</label>
                <input type="password" id="password2" name="contrasena_repetida" placeholder="Vuelva a escribir la contraseña" minlength="8" required>
                <p id="seguridad" class="mensaje-error"></p>

                <button type="submit" id="crear">Enviar solicitud</button>

                <p class="aviso-registro">
                    <span>¿Ya tiene usuario?</span> <a href="../index.php">Inicie sesión</a>
                </p>
            </form>
        </section>
    </main>

<?php include '../globales/Footer.html' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
