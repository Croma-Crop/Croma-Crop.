
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/login.css">
    <title>Iniciar Sesión</title>
    <script src="../../script/permisos.js" defer></script>
    <script src="../../script/script.js" defer></script>
    <script src="../../script/login.js" defer></script>

</head>

<body>
    <header>
<?php include '../../backend/Header.php'?>   
</header>    
<main>
        <section id="newsletter">
            <form id="formularioNewsletter">
                <h1>Datos personales</h1>

                <section id="campo-documento">
                    <label for="cedula">Cedula</label>
                    <input type="text" id="cedula" name="cedula" placeholder="Ingresá tu cedula" pattern="[1-9][0-9]{7}" required pattern="[1-9][0-9]{7}" maxlength="8" required >
                    <p id="mensaje" class="mensaje-error"></p>
                </section>
                

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Ingresá una contraseña" required>
                <p id="seguridad" class="mensaje-error"></p>

                <button type="submit" id="crear">Iniciar Sesion</button>
                <div id="campo-boton">
                <button id="extranjero">Si sos extranjero clickea aca</button>
                </div>
            </form>
        </section>
    </main>

<?php include '../../backend/Footer.php'  ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>