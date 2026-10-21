<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/registro.css">
    <title>Iniciar sesión</title>
    <script src="js/login.js" defer></script>

</head>

<body>
    <header>
        <a href="/html/global/login.php">
            <img src="img/removebg-preview.png" alt="Logo Croma Corp" id="logo">
        </a>

        <div class="acciones-header">
            <button class="btn-idioma" type="button" id="btn-idioma">EN</button>
        </div>

        <script src="js/idioma.js"></script>


</header>    
<main>
        <section id="newsletter">
            <form id="formularioNewsletter" method="post" action="../Procesos/backend/procesologin.php">
                <h1>Datos personales</h1>

                <?php if (isset($_SESSION["error"])): ?>
                <p class="mensaje-error"><?= htmlspecialchars($_SESSION["error"]) ?></p>
                <?php unset($_SESSION["error"]); ?>
                <?php endif; ?>
            
                <section id="campo-documento">
                    <label for="cedula">Cédula</label>
                    <input type="text" id="cedula" name="documento" placeholder="Ingrese su cédula" pattern="[1-9][0-9]{7}" title="Ingrese exactamente 8 dígitos sin puntos ni guiones" inputmode="numeric" maxlength="8" required>
                    <p id="mensaje" class="mensaje-error"></p>
                </section>
                

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="contrasena" placeholder="Ingrese su contraseña" required>
                <p id="seguridad" class="mensaje-error"></p>

                <button type="submit" id="crear">Iniciar sesión</button>
                <div id="campo-boton">
                <button id="extranjero" type="submit">Si es extranjero, haga clic aquí</button>
                </div>

                <p id="enlace-registro">
                    <span>¿No tiene usuario?</span> <a href="html/registro.php">Solicite uno</a>
                </p>
            </form>

        </section>
    </main>

<?php include 'globales/Footer.html'  ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>