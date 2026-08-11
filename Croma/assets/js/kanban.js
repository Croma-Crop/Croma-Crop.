const incidencias = JSON.parse(localStorage.getItem("incidencias")) || [];
const solicitudes = JSON.parse(localStorage.getItem("solicitudes")) || [];
const empleados = JSON.parse(localStorage.getItem("empleados")) || [];
const puedeClasificar = puedeHacer("asignarGravedad", usuario?.rol);

const cuadroDeBusqueda = document.querySelector("#inptbusqueda");
const botonesFiltro = document.querySelectorAll(".filtro-clase");
const columnas = document.querySelectorAll(".columna-kanban");

let claseActiva = "Todos";
let tarjetaArrastrada = null;
let tickets = [];

let nombreCompleto = "";
if (usuario) {
    nombreCompleto = usuario.nombre + " " + usuario.apellido;
}

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
        if (ticket.clase === "Incidencia" && !ticket.gravedad) {
            ticket.gravedad = "Sin clasificar";
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
    const datos = "data-clase='" + ticket.clase + "' data-indice='" + indice + "'";

    let html = "<li class='tarjeta-kanban' draggable='true' " + datos + ">";

    html += "<div class='fila-tarjeta'>";
    html += "<span class='etiqueta-clase etiqueta-" + ticket.clase.toLowerCase() + "'>" + ticket.clase + "</span>";
    if (ticket.clase === "Incidencia") {
        html += "<span class='etiqueta-gravedad " + claseDeGravedad(ticket.gravedad) + "'>" + ticket.gravedad + "</span>";
    }
    html += "</div>";

    html += "<p class='tarjeta-nombre'>" + ticket.nombreProf + "</p>";
    html += "<p class='tarjeta-tipo'>" + ticket.tipo + "</p>";
    html += "<p class='tarjeta-asignado'>Técnico: " + ticket.asignado + "</p>";

    html += "<button type='button' class='boton-detalle'>Ver más</button>";

    html += "<div class='detalle-ticket'>";

    if (ticket.clase === "Incidencia") {
        html += "<p>Fecha inicio: " + ticket.fechaInicio + "</p>";
        html += "<p>Salón: " + ticket.salon + "</p>";
        html += "<p>Serie: " + ticket.serie + "</p>";
        html += "<p>Turno: " + ticket.turno + "</p>";
    } else if (ticket.salon) {
        html += "<p>Salón: " + ticket.salon + "</p>";
    }

    html += "<p class='tarjeta-descripcion'>" + ticket.descripcion + "</p>";

    if (puedeClasificar) {
        if (ticket.asignado !== nombreCompleto) {
            html += "<button type='button' class='boton-tomar' " + datos + ">Tomar la tarea</button>";
        }

        html += "<label class='campo-kanban'>Técnico asignado";
        html += "<select class='select-tecnico' " + datos + ">";
        html += construirOpciones(tecnicos, ticket.asignado);
        html += "</select>";
        html += "</label>";

        if (ticket.clase === "Incidencia") {
            html += "<label class='campo-kanban'>Gravedad";
            html += "<select class='select-gravedad' " + datos + ">";
            html += construirOpciones(gravedades, ticket.gravedad);
            html += "</select>";
            html += "</label>";
        }

        html += "<label class='campo-kanban'>Estado";
        html += "<select class='select-estado' " + datos + ">";
        html += construirOpciones(estados, ticket.estado);
        html += "</select>";
        html += "</label>";
    }

    html += "</div>";
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

    activarDetalles();
    activarTarjetas();
}

function moverTicket(clase, indice, estado) {
    obtenerTicket(clase, indice).estado = estado;
    guardarTickets();
    renderizarTablero();
}

function asignarTecnico(tarjeta, ticket, tecnico) {
    ticket.asignado = tecnico;
    guardarTickets();
    tarjeta.querySelector(".tarjeta-asignado").textContent = "Técnico: " + tecnico;
}

function activarTarjetas() {
    document.querySelectorAll(".boton-tomar").forEach(function (boton) {
        boton.addEventListener("click", function () {
            const tarjeta = boton.closest(".tarjeta-kanban");
            const ticket = obtenerTicket(boton.dataset.clase, Number(boton.dataset.indice));

            asignarTecnico(tarjeta, ticket, nombreCompleto);
            tarjeta.querySelector(".select-tecnico").value = nombreCompleto;
            boton.remove();
        });
    });

    document.querySelectorAll(".select-tecnico").forEach(function (select) {
        select.addEventListener("change", function () {
            const tarjeta = select.closest(".tarjeta-kanban");
            const ticket = obtenerTicket(select.dataset.clase, Number(select.dataset.indice));

            asignarTecnico(tarjeta, ticket, select.value);
        });
    });

    document.querySelectorAll(".select-gravedad").forEach(function (select) {
        select.addEventListener("change", function () {
            const ticket = obtenerTicket(select.dataset.clase, Number(select.dataset.indice));
            ticket.gravedad = select.value;
            guardarTickets();

            const etiqueta = select.closest(".tarjeta-kanban").querySelector(".etiqueta-gravedad");
            etiqueta.textContent = select.value;
            etiqueta.className = "etiqueta-gravedad " + claseDeGravedad(select.value);
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
