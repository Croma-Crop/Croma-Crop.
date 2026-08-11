const incidencias = JSON.parse(localStorage.getItem("incidencias")) || [];
const solicitudes = JSON.parse(localStorage.getItem("solicitudes")) || [];
const puedeEliminar = puedeHacer("eliminarTickets", usuario?.rol);

let tickets = [];

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
}
construirTickets();

const contenedor = document.getElementById("listado-tickets");
const cuadroDeBusqueda = document.querySelector("#inptbusqueda");
const botonesFiltro = document.querySelectorAll(".filtro-clase");

let claseActiva = "Todos";

function renderizarTickets(lista) {
    let html = "";

    if (lista.length === 0) {
        contenedor.innerHTML = "<li class='sin-resultados'>No hay tickets registrados.</li>";
        return;
    }

    lista.forEach(function (ticket) {
        let indiceReal = incidencias.indexOf(ticket);
        if (ticket.clase === "Solicitud") {
            indiceReal = solicitudes.indexOf(ticket);
        }

        const estado = ticket.estado || "Pendiente";
        const asignado = ticket.asignado || "Sin asignar";

        html += "<li class='tarjeta-ticket'>";

        html += "<div class='fila-tarjeta'>";
        html += "<span class='etiqueta-clase etiqueta-" + ticket.clase.toLowerCase() + "'>" + ticket.clase + "</span>";
        html += "<span class='etiqueta-estado " + claseDeEstado(estado) + "'>" + estado + "</span>";
        html += "</div>";

        html += "<p class='tarjeta-nombre'>" + ticket.nombreProf + "</p>";
        html += "<p class='tarjeta-tipo'>" + ticket.tipo + "</p>";

        if (ticket.clase === "Incidencia") {
            const gravedad = ticket.gravedad || "Sin clasificar";
            html += "<p class='tarjeta-gravedad'>Gravedad: ";
            html += "<span class='etiqueta-gravedad " + claseDeGravedad(gravedad) + "'>" + gravedad + "</span>";
            html += "</p>";
        }

        html += "<p class='tarjeta-asignado'>Técnico: " + asignado + "</p>";

        html += "<button type='button' class='boton-detalle'>Ver más</button>";

        html += "<div class='detalle-ticket'>";

        if (ticket.clase === "Incidencia") {
            html += "<p>Fecha inicio: " + ticket.fechaInicio + "</p>";
            html += "<p>Salón: " + ticket.salon + "</p>";
            html += "<p>Serie: " + ticket.serie + "</p>";
            html += "<p>Turno: " + ticket.turno + "</p>";
            if (ticket.horaEntrada) {
                html += "<p>Hora entrada: " + ticket.horaEntrada + "</p>";
            }
            if (ticket.horaSalida) {
                html += "<p>Hora salida: " + ticket.horaSalida + "</p>";
            }
        }

        if (ticket.clase === "Solicitud" && ticket.salon) {
            html += "<p>Salón: " + ticket.salon + "</p>";
        }

        html += "<p class='tarjeta-descripcion'>" + ticket.descripcion + "</p>";
        html += "</div>";

        if (puedeEliminar) {
            html += "<button class='boton-eliminar-ticket' data-clase='" + ticket.clase + "' data-indice='" + indiceReal + "'>Eliminar</button>";
        }

        html += "</li>";
    });

    contenedor.innerHTML = html;

    activarDetalles();

    document.querySelectorAll(".boton-eliminar-ticket").forEach(function (boton) {
        boton.addEventListener("click", function () {
            const clase = boton.dataset.clase;
            const i = Number(boton.dataset.indice);

            if (confirm("¿Seguro que quiere eliminar este ticket?")) {
                if (clase === "Incidencia") {
                    incidencias.splice(i, 1);
                    localStorage.setItem("incidencias", JSON.stringify(incidencias));
                } else {
                    solicitudes.splice(i, 1);
                    localStorage.setItem("solicitudes", JSON.stringify(solicitudes));
                }
                construirTickets();
                filtrarTickets();
            }
        });
    });
}

function filtrarTickets() {
    let texto = cuadroDeBusqueda.value.toLowerCase();

    let filtrados = tickets.filter(function (ticket) {
        if (claseActiva !== "Todos" && ticket.clase !== claseActiva) {
            return false;
        }
        return ticket.nombreProf.toLowerCase().includes(texto) ||
            ticket.tipo.toLowerCase().includes(texto) ||
            ticket.descripcion.toLowerCase().includes(texto);
    });

    renderizarTickets(filtrados);
}

cuadroDeBusqueda.addEventListener("keyup", filtrarTickets);

botonesFiltro.forEach(function (boton) {
    boton.addEventListener("click", function () {
        claseActiva = boton.dataset.clase;

        botonesFiltro.forEach(function (b) {
            b.classList.remove("activo");
        });
        boton.classList.add("activo");

        filtrarTickets();
    });
});

renderizarTickets(tickets);
