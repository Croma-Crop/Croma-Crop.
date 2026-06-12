const dialog = document.querySelector(".dialogGestionarEmpleado");
const btnAbrir = document.getElementById("btnAltaEmpleado");
const btnCerrar = document.getElementById("btnCerrarGestionarEmpleado");
const formulario = document.getElementById("formularioGestionarEmpleado");
const tbody = document.getElementById("cuerpoTablaEmpleados");
const btnExtranjeroAdmin = document.getElementById("btnExtranjeroAdmin");
const contenedorDocAdmin = document.getElementById("contenedor-documento-admin");
const campoBtnAdmin = document.getElementById("campo-boton-admin");

function obtenerEmpleados() {
    return JSON.parse(localStorage.getItem("empleados")) || [];
}

function guardarEmpleados(empleados) {
    localStorage.setItem("empleados", JSON.stringify(empleados));
}

function agregarFila(empleado) {
    const fila = document.createElement("tr");

    let documento = empleado.cedula;
    if (empleado.pasaporte) {
        documento = empleado.pasaporte;
    }

    fila.innerHTML =
        "<td>" + documento + "</td>" +
        "<td>" + empleado.nombre + "</td>" +
        "<td>" + empleado.apellido + "</td>" +
        "<td>" + empleado.rol + "</td>" +
        "<td>••••••</td>" +
        "<td><button class='btnEliminarEmpleado' type='button'>Eliminar</button></td>";

    fila.querySelector(".btnEliminarEmpleado").addEventListener("click", function () {
        const empleadosActuales = obtenerEmpleados();
        const empleadosFiltrados = [];

        empleadosActuales.forEach(function (emp) {
            let doc = emp.cedula;
            if (emp.pasaporte) {
                doc = emp.pasaporte;
            }
            if (doc !== documento) {
                empleadosFiltrados.push(emp);
            }
        });

        guardarEmpleados(empleadosFiltrados);
        fila.remove();
    });

    tbody.appendChild(fila);
}

btnAbrir.addEventListener("click", function () {
    dialog.showModal();
});

btnCerrar.addEventListener("click", function () {
    dialog.close();
    formulario.reset();
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

formulario.addEventListener("submit", function (e) {
    e.preventDefault();

    const cedulaInput = document.getElementById("cedula");
    const pasaporteInput = document.getElementById("pasaporte");

    const empleado = {
        nombre: document.getElementById("nombre").value.trim(),
        apellido: document.getElementById("apellido").value.trim(),
        rol: document.getElementById("rol").value,
        contrasena: document.getElementById("contrasena").value
    };

    if (pasaporteInput) {
        empleado.pasaporte = pasaporteInput.value.trim();
    } else {
        empleado.cedula = cedulaInput.value.trim();
    }

    const empleados = obtenerEmpleados();
    empleados.push(empleado);
    guardarEmpleados(empleados);

    agregarFila(empleado);
    dialog.close();
    formulario.reset();
});

const empleadosIniciales = obtenerEmpleados();
empleadosIniciales.forEach(function (empleado) {
    agregarFila(empleado);
});
