const dialog = document.querySelector(".dialogGestionarEmpleado");
const btnAbrir = document.getElementById("btnAltaEmpleado");
const btnCerrar = document.getElementById("btnCerrarGestionarEmpleado");
const btnExtranjeroAdmin = document.getElementById("btnExtranjeroAdmin");
const contenedorDocAdmin = document.getElementById("contenedor-documento-admin");
const campoBtnAdmin = document.getElementById("campo-boton-admin");

btnAbrir.addEventListener("click", function () {
    dialog.showModal();
});

btnCerrar.addEventListener("click", function () {
    dialog.close();
});

btnExtranjeroAdmin.addEventListener("click", function () {
    contenedorDocAdmin.innerHTML = `
        <div class="cajaEntradaDeDatos">
            <label for="pasaporte">Pasaporte</label>
            <input type="text" id="pasaporte" name="pasaporte" placeholder="Ingrese el pasaporte" pattern="[A-Za-z][0-9]{7}"
            title="Una letra seguida de 7 números, ej: A1234567" autocomplete="off" required>
        </div>
    `;
    btnExtranjeroAdmin.disabled = true;
    campoBtnAdmin.innerHTML = `<button type="button" id="btnCedulaAdmin">Empleado uruguayo</button>`;
    document.getElementById("btnCedulaAdmin").addEventListener("click", function () {
        contenedorDocAdmin.innerHTML = `
            <div class="cajaEntradaDeDatos">
                <label for="cedula">Cédula</label>
                <input type="text" id="cedula" name="documento" placeholder="Ingrese la cédula"
                    autocomplete="off" pattern="[1-9][0-9]{7}"
                    title="Ingrese exactamente 8 dígitos sin puntos ni guiones" inputmode="numeric"
                    maxlength="8" required>
            </div>
        `;
        campoBtnAdmin.innerHTML = "";
        campoBtnAdmin.appendChild(btnExtranjeroAdmin);
        btnExtranjeroAdmin.disabled = false;
    });
});