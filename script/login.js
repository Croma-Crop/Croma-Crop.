const img = document.querySelector("#logo");
const cedula = document.getElementById("cedula");
const extranjero = document.querySelector("#extranjero");
const formulario = document.querySelector("#formularioNewsletter")
img.addEventListener("click", function(e) {
    e.preventDefault();
})

cedula.addEventListener("input", () => {
    cedula.value = cedula.value.replace(/\D/g, "");
});

extranjero.addEventListener("click", function(e){
    e.preventDefault();

    const contenedor = document.getElementById("campo-documento");
    contenedor.innerHTML = `
        <label for="pasaporte">Pasaporte</label>
        <input type="text" id="pasaporte" name="pasaporte" placeholder="Ingresá tu pasaporte" maxlength="8" required>
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
            <input type="text" id="cedula" name="cedula" placeholder="Ingresá tu cedula" required>
            <p id="mensaje" class="mensaje-error"></p>
        `;
        campoboton.innerHTML = "";
        campoboton.appendChild(extranjero);
        extranjero.disabled = false;
    });
})

formulario.addEventListener("submit", function(e) {
    e.preventDefault();

    const cedulaInput = document.getElementById("cedula");
    const pasaporteInput = document.getElementById("pasaporte");
    const passwordIngresada = document.getElementById("password").value;
    const mensaje = document.getElementById("mensaje");

    const empleados = JSON.parse(localStorage.getItem("empleados")) || [];
    let empleado;

    if (pasaporteInput) {
        const pasaporteIngresado = pasaporteInput.value.trim();
        empleado = empleados.find(e => e.pasaporte === pasaporteIngresado && e.contrasena === passwordIngresada);
        if (!empleado) {
            mensaje.textContent = "Pasaporte o contraseña incorrectos.";
            return;
        }
    } else {
        const cedulaIngresada = cedulaInput?.value.trim() ?? "";
        empleado = empleados.find(e => e.cedula === cedulaIngresada && e.contrasena === passwordIngresada);
        if (!empleado) {
            mensaje.textContent = "Cédula o contraseña incorrectos.";
            return;
        }
    }

    mensaje.textContent = "";
    alert("Bienvenido, " + empleado.nombre + " " + empleado.apellido + ".");
});