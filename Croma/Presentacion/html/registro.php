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
            <button class="btn-idioma notranslate" type="button" id="btn-idioma" translate="no">EN</button>
            <div id="google_translate_element"></div>
        </div>

        <script src="../js/idioma.js"></script>
        <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    </header>
    <main>
        <section id="newsletter">
            <form id="formularioRegistro" method="post" action="../../Procesos/backend/procesoregistro.php">
                <h1>Solicitar usuario</h1>

                <p class="aviso-registro">Un administrador tiene que aprobar la solicitud antes de darte el acceso.</p>

                <?php if (isset($_GET["mensaje"])): ?>
                    <div class="mensaje mensaje-<?= ($_GET["tipo"] ?? "") === "exito" ? "exito" : "error" ?>">
                        <?= htmlspecialchars($_GET["mensaje"]) ?>
                    </div>
                <?php endif; ?>

                <section id="campo-documento">
                    <label for="cedula">Cedula</label>
                    <input type="text" id="cedula" name="documento" placeholder="Ingresá tu cedula" pattern="[1-9][0-9]{7}" title="Ingrese exactamente 8 dígitos sin puntos ni guiones" inputmode="numeric" maxlength="8" required>
                    <p id="mensaje" class="mensaje-error"></p>
                </section>

                <div id="campo-boton">
                    <button id="extranjero">Si sos extranjero clickea aca</button>
                </div>

                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingresá tu nombre" autocomplete="given-name" maxlength="50" required>

                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" placeholder="Ingresá tu apellido" autocomplete="family-name" maxlength="50" required>

                <label for="rol_pedido">Rol que te corresponde</label>
                <select id="rol_pedido" name="rol_pedido" required>
                    <option value="">--- Seleccionar rol ---</option>
                    <option value="solicitante">Solicitante (docente)</option>
                    <option value="tecnico">Técnico</option>
                    <option value="administrador">Administrador</option>
                </select>

                <label for="motivo">¿Para qué necesitás el usuario?</label>
                <input type="text" id="motivo" name="motivo" placeholder="Ej: soy docente de 3ro" required>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="contrasena" placeholder="Al menos 8 caracteres" minlength="8" required>

                <label for="password2">Repetir contraseña</label>
                <input type="password" id="password2" name="contrasena_repetida" placeholder="Volvé a escribir la contraseña" minlength="8" required>
                <p id="seguridad" class="mensaje-error"></p>

                <button type="submit" id="crear">Enviar solicitud</button>

                <p class="aviso-registro">
                    ¿Ya tenés usuario? <a href="../index.php">Iniciá sesion</a>
                </p>
            </form>
        </section>
    </main>

<?php include '../globales/Footer.html' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
