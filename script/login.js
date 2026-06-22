const empleadosGuardados = JSON.parse(localStorage.getItem("empleados")) || [];

let hayAdmin = false;
empleadosGuardados.forEach(function (empleado) {
    if (empleado.rol === "admin") {
        hayAdmin = true;
    }
});

if (!hayAdmin) {
    empleadosGuardados.push(
        { cedula: "11111111", nombre: "Admin", apellido: "Prueba", rol: "admin", contrasena: "fafealmo" },
        { cedula: "22222222", nombre: "Tecnico", apellido: "Prueba", rol: "tecnico", contrasena: "fafealmo" },
        { cedula: "33333333", nombre: "Usuario", apellido: "Prueba", rol: "solicitante", contrasena: "fafealmo" }
    );
    localStorage.setItem("empleados", JSON.stringify(empleadosGuardados));
}

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
        empleado = empleados.find(function (emp) {
            return emp.pasaporte === pasaporteIngresado && emp.contrasena === passwordIngresada;
        });
        if (!empleado) {
            mensaje.textContent = "Pasaporte o contraseña incorrectos.";
            return;
        }
    } else {
        let cedulaIngresada = "";
        if (cedulaInput) {
            cedulaIngresada = cedulaInput.value.trim();
        }
        empleado = empleados.find(function (emp) {
            return emp.cedula === cedulaIngresada && emp.contrasena === passwordIngresada;
        });
        if (!empleado) {
            mensaje.textContent = "Cédula o contraseña incorrectos.";
            return;
        }
    }

    mensaje.textContent = "";
    sessionStorage.setItem("usuarioActivo", JSON.stringify({
        nombre: empleado.nombre, apellido: empleado.apellido, rol: empleado.rol}));

   
    if (empleado.rol === "admin" || empleado.rol === "tecnico") {
        window.location.href = "../../html/admin/index_funcionarios.html";
    } else {
        window.location.href = "../../html/user/index_user.html";
    }
});
