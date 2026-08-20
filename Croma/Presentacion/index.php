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
    <title>Iniciar Sesión</title>
    <script src="js/login.js" defer></script>

</head>

<body>
    <header>
        <a href="/html/global/login.php">
            <img src="img/removebg-preview.png" alt="Logo Croma Corp" id="logo">
        </a>
        
        <div class="dropdown">
            <img src="img/menu.png" alt="burguer" id="burguer" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer">
            <ul class="dropdown-menu"></ul>
        </div>


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
                    <label for="cedula">Cedula</label>
                    <input type="text" id="cedula" name="documento" placeholder="Ingresá tu cedula" pattern="[1-9][0-9]{7}" required pattern="[1-9][0-9]{7}" maxlength="8" required >
                    <p id="mensaje" class="mensaje-error"></p>
                </section>
                

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="contrasena" placeholder="Ingresá una contraseña" required>
                <p id="seguridad" class="mensaje-error"></p>

                <button type="submit" id="crear">Iniciar Sesion</button>
                <div id="campo-boton">
                <button id="extranjero">Si sos extranjero clickea aca</button>
                </div>
            </form>
        </section>
    </main>

<?php include 'globales/Footer.php'  ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>