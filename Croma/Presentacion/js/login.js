const img = document.querySelector("#logo");
const cedula = document.getElementById("cedula");
const extranjero = document.querySelector("#extranjero");

img.addEventListener("click", function(e) {
    e.preventDefault();
});

cedula.addEventListener("input", () => {
    cedula.value = cedula.value.replace(/\D/g, "");
});

extranjero.addEventListener("click", function(e){
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
    document.getElementById("btnCedula").addEventListener("click", function(e){
        e.preventDefault();
        const contenedor = document.getElementById("campo-documento");
        contenedor.innerHTML = `
            <label for="cedula">Cedula</label>
            <input type="text" id="cedula" name="cedula" placeholder="Ingresá tu cedula" pattern="[A-Za-z][0-9]{7}"
          maxlength="8" required>
            <p id="mensaje" class="mensaje-error"></p>
        `;
        campoboton.innerHTML = "";
        campoboton.appendChild(extranjero);
        extranjero.disabled = false;
    });
});