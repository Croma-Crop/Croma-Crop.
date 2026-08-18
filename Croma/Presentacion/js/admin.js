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
                <input type="text" id="cedula" name="cedula" placeholder="Ingrese la cédula"
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

const cuerpoTabla = document.getElementById("cuerpoTablaEmpleados");

async function cargarEmpleados() {
    try {
        const resp = await fetch("listar_empleados.php");
        const empleados = await resp.json();

        if (!resp.ok) {
            console.error(empleados.error);
            return;
        }

        cuerpoTabla.innerHTML = "";
        empleados.forEach(emp => {
            const fila = document.createElement("tr");
            fila.innerHTML = `
                <td>${emp.documento}</td>
                <td>${emp.nombre}</td>
                <td>${emp.apellido}</td>
                <td>${emp.rol}</td>
                <td>••••••••</td>
                <td></td>
            `;
            cuerpoTabla.appendChild(fila);
        });
    } catch (error) {
        console.error("Error al cargar empleados:", error);
    }
}

const formulario = document.getElementById("formularioGestionarEmpleado");

formulario.addEventListener("submit", async function (evento) {
    evento.preventDefault(); 
    const datos = new FormData(formulario);

    try {
        const resp = await fetch("guardar_empleado.php", {
            method: "POST",
            body: datos
        });
        const resultado = await resp.json();

        if (!resp.ok) {
            alert(resultado.error || "No se pudo guardar el empleado");
            return;
        }

        formulario.reset();
        dialog.close();
        cargarEmpleados(); 
    } catch (error) {
        console.error("Error al guardar empleado:", error);
        alert("Ocurrió un error al guardar el empleado");
    }
});

cargarEmpleados();