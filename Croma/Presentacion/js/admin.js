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

async function cargarUsuarios() {
    try {
        const resp = await fetch("listar_usuario.php");
        const usuarios = await resp.json();

        if (!resp.ok) {
            console.error(usuarios.error);
            return;
        }

        cuerpoTabla.innerHTML = "";
        usuarios.forEach(usuario => {
            const fila = document.createElement("tr");
            fila.innerHTML = `
                <td>${usuario.documento}</td>
                <td>${usuario.nombre}</td>
                <td>${usuario.apellido}</td>
                <td>${usuario.rol}</td>
                <td>*******</td>
                <td><button type="button" class="btnEliminarEmpleado" data-doc="${usuario.documento}">Eliminar</button></td>
            `;
            cuerpoTabla.appendChild(fila);
        });
    } catch (error) {
        console.error("Error al cargar usuarios:", error);
    }
}

cuerpoTabla.addEventListener("click", async function (evento) {
    if (!evento.target.classList.contains("btnEliminarEmpleado")) return;
    
    const documento = evento.target.dataset.doc;
    const confirmar = confirm(`¿Seguro que querés eliminar al usuario con documento ${documento}?`);
    if (!confirmar) return;

    try {
        const datos = new FormData();
        datos.append("documento", documento);

        const resp = await fetch("eliminar_usuario.php", {
            method: "POST",
            body: datos
        });
        const resultado = await resp.json();

        if (!resp.ok) {
            alert(resultado.error || "No se pudo eliminar el usuario");
            return;
        }

        cargarUsuarios();
    } catch (error) {
        console.error("Error al eliminar usuario:", error);
        alert("Ocurrió un error al eliminar el usuario");
    }
});

const formulario = document.getElementById("formularioGestionarEmpleado");

formulario.addEventListener("submit", async function (evento) {
    evento.preventDefault();
    const datos = new FormData(formulario);

    try {
        const resp = await fetch("guardar_usuario.php", { method: "POST", body: datos });
        const resultado = await resp.json();

        if (resultado.error) {
            alert(resultado.error);
            return;
        }

        formulario.reset();
        dialog.close();
        cargarUsuarios();
    } catch (error) {
        console.error("Error al guardar usuario:", error);
    }
});

cargarUsuarios();