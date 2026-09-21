const img = document.querySelector("#logo");
const cedula = document.getElementById("cedula");
const extranjero = document.querySelector("#extranjero");
const formularioRegistro = document.querySelector("#formularioRegistro");
const password = document.querySelector("#password");
const password2 = document.querySelector("#password2");
const seguridad = document.querySelector("#seguridad");

img.addEventListener("click", function (e) {
    e.preventDefault();
});

cedula.addEventListener("input", () => {
    cedula.value = cedula.value.replace(/\D/g, "");
});

extranjero.addEventListener("click", function (e) {
    e.preventDefault();

    const contenedor = document.getElementById("campo-documento");
    contenedor.innerHTML = `
        <label for="pasaporte">Pasaporte</label>
        <input type="text" id="pasaporte" name="pasaporte" placeholder="Ingresá tu pasaporte" pattern="[A-Za-z][0-9]{7}"
         title="Una letra seguida de 7 números, ej: A1234567" maxlength="8" required>
        <p id="mensaje" class="mensaje-error"></p>
    `;

    extranjero.disabled = true;
    const campoboton = document.querySelector("#campo-boton");
    campoboton.innerHTML = `
    <button id="btnCedula">Si sos uruguayo clickea aca</button>
    `;
    document.getElementById("btnCedula").addEventListener("click", function (e) {
        e.preventDefault();
        const contenedor = document.getElementById("campo-documento");
        contenedor.innerHTML = `
            <label for="cedula">Cedula</label>
            <input type="text" id="cedula" name="documento" placeholder="Ingresá tu cedula" pattern="[1-9][0-9]{7}"
          title="Ingrese exactamente 8 dígitos sin puntos ni guiones" inputmode="numeric" maxlength="8" required>
            <p id="mensaje" class="mensaje-error"></p>
        `;
        campoboton.innerHTML = "";
        campoboton.appendChild(extranjero);
        extranjero.disabled = false;
    });
});

formularioRegistro.addEventListener("submit", function (e) {
    if (password.value !== password2.value) {
        e.preventDefault();
        seguridad.textContent = "Las dos contraseñas no coinciden.";
    }
});
