const img = document.querySelector("#logo");
const cedula = document.getElementById("cedula");
const extranjero = document.querySelector("#extranjero");
const formRegistro = extranjero.closest("form");
const actionRegistro = formRegistro.getAttribute("action");

img.addEventListener("click", function(e) {
    e.preventDefault();
});

cedula.addEventListener("input", () => {
    cedula.value = cedula.value.replace(/\D/g, "");
});

extranjero.addEventListener("click", function(e){
    e.preventDefault();
    formRegistro.action = actionRegistro + "?tipo=extranjero";

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
    document.getElementById("btnCedula").addEventListener("click", function(e){
        e.preventDefault();
        formRegistro.action = actionRegistro;
        const contenedor = document.getElementById("campo-documento");
        contenedor.innerHTML = `
            <label for="cedula">Cedula</label>
            <input type="text" id="cedula" name="documento" placeholder="Ingresá tu cedula" pattern="[1-9][0-9]{7}"
          title="Ingrese exactamente 8 dígitos sin puntos ni guiones" inputmode="numeric" maxlength="8" required>
            <p id="mensaje" class="mensaje-error"></p>
        `;
        campoboton.innerHTML = "";
        document.getElementById("cedula").addEventListener("input", function () {
    this.value = this.value.replace(/\D/g, "");
        });

        campoboton.appendChild(extranjero);
        extranjero.disabled = false;
    });
});