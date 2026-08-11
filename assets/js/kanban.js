const incidencias = JSON.parse(localStorage.getItem("incidencias")) || [];
const solicitudes = JSON.parse(localStorage.getItem("solicitudes")) || [];
const empleados = JSON.parse(localStorage.getItem("empleados")) || [];

const cuadroDeBusqueda = document.querySelector("#inptbusqueda");
const botonesFiltro = document.querySelectorAll(".filtro-clase");
const columnas = document.querySelectorAll(".columna-kanban");

let claseActiva = "Todos";
let tarjetaArrastrada = null;
let tickets = [];

const tecnicos = ["Sin asignar"];
empleados.forEach(function (empleado) {
    if (empleado.rol === "tecnico") {
        tecnicos.push(empleado.nombre + " " + empleado.apellido);
    }
});

function construirTickets() {
    tickets = [];

    incidencias.forEach(function (incidencia) {
        incidencia.clase = "Incidencia";
        tickets.push(incidencia);
    });
    solicitudes.forEach(function (solicitud) {
        solicitud.clase = "Solicitud";
        tickets.push(solicitud);
    });

    tickets.forEach(function (ticket) {
        if (!ticket.estado) {
            ticket.estado = "Pendiente";
        }
        if (!ticket.asignado) {
            ticket.asignado = "Sin asignar";
        }
    });
}
construirTickets();

function guardarTickets() {
    localStorage.setItem("incidencias", JSON.stringify(incidencias));
    localStorage.setItem("solicitudes", JSON.stringify(solicitudes));
}

function obtenerTicket(clase, indice) {
    if (clase === "Solicitud") {
        return solicitudes[indice];
    }
    return incidencias[indice];
}

function obtenerIndice(ticket) {
    if (ticket.clase === "Solicitud") {
        return solicitudes.indexOf(ticket);
    }
    return incidencias.indexOf(ticket);
}

function seMuestra(ticket, texto) {
    if (claseActiva !== "Todos" && ticket.clase !== claseActiva) {
        return false;
    }
    return ticket.nombreProf.toLowerCase().includes(texto) ||
        ticket.tipo.toLowerCase().includes(texto) ||
        ticket.descripcion.toLowerCase().includes(texto);
}

function construirTarjeta(ticket) {
    const indice = obtenerIndice(ticket);

    let html = "<li class='tarjeta-kanban' draggable='true' data-clase='" + ticket.clase + "' data-indice='" + indice + "'>";
    html += "<p class='tarjeta-clase tarjeta-" + ticket.clase.toLowerCase() + "'>" + ticket.clase + "</p>";
    html += "<p class='tarjeta-nombre'>" + ticket.nombreProf + "</p>";
    html += "<p class='tarjeta-tipo'>Tipo: " + ticket.tipo + "</p>";

    if (ticket.salon) {
        html += "<p>Salón: " + ticket.salon + "</p>";
    }

    if (ticket.clase === "Incidencia") {
        const gravedad = ticket.gravedad || "Sin clasificar";
        const prioridad = ticket.prioridad || "Sin asignar";

        html += "<p class='tarjeta-gravedad'>Gravedad: ";
        html += "<span class='etiqueta-gravedad " + claseDeGravedad(gravedad) + "'>" + gravedad + "</span>";
        html += "</p>";
        html += "<p class='tarjeta-prioridad'>Prioridad: " + prioridad + "</p>";
    }

    html += "<p class='tarjeta-descripcion'>" + ticket.descripcion + "</p>";

    html += "<label class='campo-kanban'>Técnico asignado";
    html += "<select class='select-tecnico' data-clase='" + ticket.clase + "' data-indice='" + indice + "'>";
    html += construirOpciones(tecnicos, ticket.asignado);
    html += "</select>";
    html += "</label>";

    html += "<label class='campo-kanban'>Estado";
    html += "<select class='select-estado' data-clase='" + ticket.clase + "' data-indice='" + indice + "'>";
    html += construirOpciones(estados, ticket.estado);
    html += "</select>";
    html += "</label>";

    html += "</li>";
    return html;
}

function renderizarTablero() {
    const texto = cuadroDeBusqueda.value.toLowerCase();

    estados.forEach(function (estado) {
        const lista = document.querySelector(".lista-kanban[data-estado='" + estado + "']");
        const contador = document.querySelector(".contador-kanban[data-estado='" + estado + "']");

        let html = "";
        let cantidad = 0;

        tickets.forEach(function (ticket) {
            if (ticket.estado === estado && seMuestra(ticket, texto)) {
                html += construirTarjeta(ticket);
                cantidad++;
            }
        });

        if (cantidad === 0) {
            html = "<li class='sin-tarjetas'>No hay tickets en esta columna.</li>";
        }

        lista.innerHTML = html;
        contador.textContent = cantidad;
    });

    activarTarjetas();
}

function moverTicket(clase, indice, estado) {
    obtenerTicket(clase, indice).estado = estado;
    guardarTickets();
    renderizarTablero();
}

function activarTarjetas() {
    document.querySelectorAll(".select-tecnico").forEach(function (select) {
        select.addEventListener("change", function () {
            const ticket = obtenerTicket(select.dataset.clase, Number(select.dataset.indice));
            ticket.asignado = select.value;
            guardarTickets();
        });
    });

    document.querySelectorAll(".select-estado").forEach(function (select) {
        select.addEventListener("change", function () {
            moverTicket(select.dataset.clase, Number(select.dataset.indice), select.value);
        });
    });

    document.querySelectorAll(".tarjeta-kanban").forEach(function (tarjeta) {
        tarjeta.addEventListener("dragstart", function (e) {
            tarjetaArrastrada = tarjeta;
            tarjeta.classList.add("arrastrando");
            e.dataTransfer.setData("text/plain", tarjeta.dataset.indice);
        });

        tarjeta.addEventListener("dragend", function () {
            tarjeta.classList.remove("arrastrando");
        });
    });
}

columnas.forEach(function (columna) {
    columna.addEventListener("dragover", function (e) {
        e.preventDefault();
        columna.classList.add("columna-activa");
    });

    columna.addEventListener("dragleave", function () {
        columna.classList.remove("columna-activa");
    });

    columna.addEventListener("drop", function (e) {
        e.preventDefault();
        columna.classList.remove("columna-activa");

        if (tarjetaArrastrada) {
            const clase = tarjetaArrastrada.dataset.clase;
            const indice = Number(tarjetaArrastrada.dataset.indice);
            tarjetaArrastrada = null;
            moverTicket(clase, indice, columna.dataset.estado);
        }
    });
});

cuadroDeBusqueda.addEventListener("keyup", renderizarTablero);

botonesFiltro.forEach(function (boton) {
    boton.addEventListener("click", function () {
        claseActiva = boton.dataset.clase;

        botonesFiltro.forEach(function (b) {
            b.classList.remove("activo");
        });
        boton.classList.add("activo");

        renderizarTablero();
    });
});

renderizarTablero();
